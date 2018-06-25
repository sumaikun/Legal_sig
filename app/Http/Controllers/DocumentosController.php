<?php

namespace Sig\Http\Controllers;

use Illuminate\Http\Request;

use Sig\Http\Requests;

use Auth;

use DB;

use Sig\Models\Empresa;

use Sig\Models\DocCategoria;

use Sig\Models\Documento;

use Sig\Models\Year;

use Sig\Helpers\Externclass;

use Sig\Helpers\Validation;

use Sig\Helpers\Permission;

use Carbon\Carbon;

use \Storage;

use Cache;

use Sig\Models\Correo;

use Sig\Models\MailPermission;

use Sig\Models\Usuario;

use Mail;


class DocumentosController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth');        
        $this->middleware('consult',['only'=>['createJuridica','createBoletines']]);  
        if(Auth::user()!=null) 
        {    
            if(Auth::user()->rol_id!=1)
            {               
                $array = Permission::Permission_array();
                $this->empresas=Empresa::Wherein('idempresa',$array)->lists('nombre','idempresa'); 
            }   
            else
            {     
                $this->empresas=Empresa::lists('nombre','idempresa');
            }
        }
        else
        {
            return  redirect()->guest('/');
        }    
        $this->usuario = Auth::user()->idusuario;
       
    }

    public function show_documentos()
    {
    	$categorias = Doccategoria::orderBy('nombre')->get();
    	$empresas = $this->empresas;
    	return view('documentos.documentos',compact('categorias','empresas'));
    }

     public function create_categoria(Request $request)
    {
    	$rules = ['nombre'=>'required'];
    	$this->validate($request,$rules);
        $categoria = new Doccategoria;
        $categoria ->id = Externclass::id_generator($categoria,'id');
        $categoria->nombre = $request->nombre;
        $validation = Validation::check_create_repeat($categoria , $request->nombre ,'nombre');
        if($validation == 'allow' )
        {
        	$categoria->save();
        	return redirect('/Documentos')->with('message','store');
        }
        else{
        	return redirect('/Documentos')->with('message','failed');	
        }
                   
    }

    public function editar_categoria($id)
	{
        $categoria =  Doccategoria::find($id);        
        return view('documentos.editarcategoria',compact('categoria'));           
    }

    public function update_categoria(Request $request)
    {
    	$rules = ['nombre'=>'required'];
    	$this->validate($request,$rules);
    	$categoria = Doccategoria::find($request->id);
    	$categoria->nombre = $request->nombre;    	    
        $table = new Doccategoria();
        $validation = Validation::check_update_repeat($request->nombre,$table,'nombre','id',$request->id);
        if($validation == 'allow' )
        {
        	$categoria->save();
        	return redirect('/Documentos')->with('message','updated');
        }
        else{
        	return redirect('/Documentos')->with('message','failed');	
        }

    }

    public function ver_categoria($id)
    {
        $years = Year::where('year','!=','N.A.')->where('year','>=',2010)->orderBy('year')->lists('year','id');
        //return $years;
        //return $years;
    	 if(Auth::user()->rol_id!=1)
        {
        	$array = Permission::Permission_array();
    		$documentos = Documento::where('id_categoria','=',$id)->Wherein('empresa',$array)->orderBy('empresa')->orderBy('mes','desc')->get();
    	}
    	else{

    		$documentos = Documento::where('id_categoria','=',$id)->orderBy('empresa')->orderBy('mes','desc')->get();
    		//return $documentos;	
    	}
    	$categoria = DocCategoria::where('id','=',$id)->first(); 
    	$empresas = $this->empresas;

        //echo $documentos;
    	return view('documentos.vercategoria',compact('documentos','categoria','empresas','years','id'));
    }


       public function downloadfile($file)
    {
            if(file_exists(storage_path('documentos/'.$file)))
            {
                $file_path = storage_path('documentos/'.$file);
                return response()->download($file_path);
            
            }

            else {
                return "no existe el documento";
            }             
    }

       public function downloadfile2($file)
    {
            if(file_exists(storage_path('documentos_anexos/'.$file)))
            {
                $file_path = storage_path('documentos_anexos/'.$file);
                return response()->download($file_path);
            
            }

            else {
                return "no existe el documento";
            }             
    }

     public function create_documento(Request $request)
    {

        $archivo = $request->file('archivo');
        $archivo2 = $request->file('archivo2');
        $titulo = $request->titulo;    
        $request->mes = $request->mes.'-00';
        //return "este es el mes ".$mons[$mes];        
        $name=$archivo->getClientOriginalName();             
        $alert = $this->filemanage($archivo,'documentos');

        if($archivo2 != null)
        {
            $name2=$archivo2->getClientOriginalName();             
            $alert2 = $this->filemanage($archivo,'documentos_anexos');    
        }
        else{
            $alert2="valid";
            $name2 = null;
        }
        
            if ($alert=='invalid' or $alert2 =='invalid')
            {
                return redirect('/ingresarCategoria/'.$request->categoria)->with('message','invalid');    
            }     
            else
            {
                $documento = new Documento;
                $documento->id = Externclass::id_generator($documento,'id');
                $documento->id_documento = Externclass::cons_generator($request->categoria);
                $documento->user = $this->usuario;
                $documento->nombre = $request->nombre;
                $documento->archivo = $name;
                $documento->anexo = $name2;    
                $documento->mes = $request->mes;
                $documento->empresa = $request->empresa;                
                $documento->id_categoria = $request->categoria;
                Cache::put('iddoc',$documento->id, 1);
                $documento->save();

                $permisos = MailPermission::where("empresa",'=',$request->empresa)->first();
                if($permisos != null)
                {
                    $usuarios = explode(",", $permisos->usuarios);                   
                    if(isset($usuarios[0]))
                    {
                        foreach($usuarios as $usuario)
                        {
                            $user = Usuario::where('idusuario','=',$usuario)->first();
                            if(isset($user->nombre))
                            {
                                $nombre_usuario =  $user->nombre;
                                $nombre_documento = $request->nombre;
                                Mail::send('Mail.layout.mail1',compact('nombre_usuario','nombre_documento'), function($msj) use($user)
                                    {
                                        $msj->subject("Tiene un nuevo documento legal disponible. Suministrado por Grupo SIG");
                                        $msj->to($user->correo); 
                                    });

                                $contents = view('Mail.layout.mail1', compact('nombre_usuario','nombre_documento'))->render();
                                
                                //Cambios
                                $query = "select max(id) as id from correos";
                                $dataset = DB::select(DB::raw($query)); 
                                
                                $correo_id = 1+$dataset[0]->id;

                                $correo = new Correo();

                                $correo->id = $correo_id;
                                $correo->proceso = "Documentos";
                                $correo->emisor = Auth::user()->idusuario;                
                                $correo->html = $contents;
                                $correo->asunto = "Tiene un nuevo documento legal disponible. Suministrado por Grupo SIG";
                                $correo->estado = 2;
                                $correo->receptor = $usuario;
                                $correo->save();    
                            }
                                
                        }   
                    }
                    
                }
            
            }
            

            return redirect('/ingresarCategoria/'.$request->categoria)->with('message','store');           
    }

    public function editar_documento($id)
    {
        $empresas = $this->empresas;
        $documento = Documento::Where('id','=',$id)->first();
        $categorias = Doccategoria::lists('nombre','id');
        return view('documentos.editardocumento',compact('categorias','id','documento','empresas'));
    }


    public function update_documento(Request $request)
    {

        $request->mes = $request->mes.'-00';
        $documento = Documento::find($request->id);
        $documento->mes = $request->mes.'-00';        
        $documento->nombre = $request->nombre;
        $documento->mes = $request->mes;
        $documento->user = $this->usuario;
        $documento->empresa = $request->empresa;
        $documento->id_categoria = $request->categoria;
        $archivo = $request->file('archivo');
        $archivo2 = $request->file('archivo2');
        if($archivo != null )
        {
                $table = new Documento();
                $property = 'id';
                $argument = $request->id;
                $file = 'archivo';

            Externclass::deletefiles($table,$property,$argument,$file,'documentos');

            $alert = $this->filemanage($archivo,'documentos');
            if ($alert=='invalid')
             {
                return redirect('/ingresarCategoria/'.$documento->id_categoria)->with('message','invalid');  
             }   

             else
             {  
                $name=$archivo->getClientOriginalName();                    
                $documento ->archivo= $name;
             }   

        }
        if($archivo2 != null )
        {
            $table = new Documento();
                $property = 'id';
                $argument = $request->id;
                $file = 'anexo';

            Externclass::deletefiles($table,$property,$argument,$file,'documentos_anexos');

            $alert = $this->filemanage($archivo2,'documentos_anexos');
            if ($alert=='invalid')
             {
                return redirect('/ingresarCategoria/'.$documento->id_categoria)->with('message','invalid');  
             }   

             else
             {  
                $name=$archivo2->getClientOriginalName();
                $documento ->anexo= $name;
             }             
        }    
       
        Cache::put('iddoc',$request->id, 1);
        $documento -> save();
         //return $documento;
        return redirect('/ingresarCategoria/'.$documento->id_categoria)->with('message','updated');     

    }

    public function filter_view($id,$year,$ent){

        $years = Year::lists('year','id'); 

         $documentos = Documento::where(function($query) use($year,$years){
            if ($year!=0)
            {
                 $query->where(DB::raw('YEAR(mes)'),"LIKE",'%'.$years[$year].'%');
                 //echo  var_dump($query);
            }
            return $query;
         })->where(function($query) use ($ent){
            if ($ent!=0)
            {
                 $query->where('empresa',"=",$ent);
            }
            else{
                if(Auth::user()->rol_id!=1)
                {
                    $array = Permission::Permission_array();
                    $query->Wherein('empresa',$array);
                }                
            }
            return $query;
         })->where(function($query) use ($id){
            
             $query->where('id_categoria',"=",$id);
            
            return $query;
         })->orderBy('mes','desc')->get();

         return view('documentos.ajax.tableajax',compact('documentos'));
    }

    public function delete_doc($id){
        $table = new Documento();
        $property = 'id';
        $argument = $id;
        $file = 'archivo';
        Externclass::deletefiles($table,$property,$argument,$file,'documentos');

        $documento = Documento::find($id);
        $documento->delete();
        return redirect('/ingresarCategoria/8')->with('message','deleted');       
    }


     private function filemanage($archivo,$disk)
    {           
        $extension = $archivo->getClientOriginalExtension();
        $extension = strtolower($extension);

        if ($extension!='docx'&&$extension!='doc'&&$extension!='pdf'&&$extension!='ppt'&&$extension!='pptx' &&$extension!='xlsx'&&$extension!='xls'&&$extension!='msg')
        {
           return "invalid";   
        }     
        else
        {   
        
        $name=$archivo->getClientOriginalName();            
        $upload=Storage::disk($disk)->put($name,  \File::get($archivo) );

            if($upload)
            {
                               
                return "storaged";
            }
        }  
    }



}


