<?php

namespace Sig\Http\Controllers;

use Illuminate\Http\Request;

use Sig\Http\Requests;

use Auth;

use Sig\Models\Usuario;

use Sig\Models\Empresa;

use Sig\Models\Evaluacion;

use Sig\Models\Correo;

use Sig\Models\Documento;

use Sig\Models\MailPermission;

use Sig\Helpers\Externclass;

use Sig\Actions\asignar_permisos_correo;

use DB;

use DateTime;

use Mail;

use Session;

use Cookie;

class MailController extends Controller
{

  	public function __construct()
    {
    	$this->middleware('auth');

         if(Auth::user()!=null) 
        {  
         	$this->usuario = Auth::user()->idusuario;
        } 
        else
        {
            return  redirect()->guest('/');
        }
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

    private function mail_reqs()
    {
        $empresas = Empresa::All();
        foreach($empresas as $empresa)
        {
        	$evaluaciones = DB::select(DB::raw('Select DISTINCT fecha_prox = (select MAX(Evaluacion.fecha_prox)  from Evaluacion LEFT JOIN Requisitos on Evaluacion.id_Requisitos = Requisitos.id where Requisitos.id = req.id ) as conditioner, fecha_prox  from Evaluacion as eval  inner join Requisitos as req on eval.id_Requisitos = req.id  where req.id_Empresa = '.$empresa->idempresa.' having conditioner = 1 or conditioner is null'));
        	foreach($evaluaciones as $evaluacion)
        	{
                //print_r($evaluacion);
        		$days = Externclass::time_dates($evaluacion->fecha_prox);
        		if($days<=30)
        		{
        			$existence = Correo::where('proceso','=','requisitos')->where('id_proceso','=',$evaluacion->fecha_prox)->first();
        			if($existence == null)
        			{
        				$correo = new Correo();    	
                        //cambio			
    				    $dataset = DB::select(DB::raw("select max(id) as id from correos")); 
    		     	    $id = 1+$dataset[0]->id;       
    			        $correo->id =  $id;
    			        $correo->proceso = 'requisitos';
    			        $correo->id_proceso = $evaluacion->fecha_prox;
                        $correo->estado = 1;
                        //$eval_empresa = DB::select(DB::raw("Select id_empresa as empresa from evaluacion as e inner join requisitos as r on e.id_Requisitos = r.id LIMIT 1"));
                        //print_r($eval_empresa);
                        $correo->empresa = $empresa->idempresa;
    				    $correo->save();

        			}
        		}
        		
        	}
        }
    	
    }

    public function index()
    {
        return view('Mail.mail_menu');
    }

    public function email_panel()
    {
    	$this->mail_reqs();
    	$correos = Correo::where('estado','=',1)->get();
    	return view('Mail.mail',compact('correos'));
    }

    public function delete($id)
    {
    	$correo = Correo::find($id);
    	$correo->estado = 2;
    	$correo->save();
    	return redirect('/Correo')->with('message','deleted'); 
    }

    public function form($id)
    {
    	$correo = Correo::find($id);
    	if($this->validateDate($correo->id_proceso, 'Y-m-d'))
    	{
    		return view('Mail.Ajax.plantillarequisitos');
    	}
    	else{
    		//return view('Mail.Ajax.plantilladocumentos');
    	}
    }

    public function send(Request $request)
    {
        //print_r($_POST);   
        //return $request->emailid;
        $correo = Correo::find($request->emailid);
        //return $correo;
        $documento = Documento::where('id','=',$correo->id_proceso)->first();
        
        $empresa = $documento->empresas->nombre;
        
        $mensaje = $request->mensaje;

        //return view('Mail.layout.mail1',compact('empresa','mensaje'));
        //Documento
        
        $empresa_id = $documento->empresas->idempresa;



        $usuarios = Usuario::where('EmpresasPermiso','LIKE','%'.$empresa.'%')->where('rol_id','!=',1)->get();



        foreach($usuarios as $usuario)
        {
            $permisos = MailPermission::where("empresa",'=',$empresa_id)->first();
            if($permisos != null)
            {
                $user_array = explode(",", $permisos->usuarios);
                if(in_array($usuario->idusuario,$user_array))
                {
                    Mail::send('Mail.layout.mail1',compact('empresa','mensaje'), function($msj)
                    {
                        $msj->subject("Notificación reqlegal");
                        $msj->to($usuario->correo); 
                    });    
                }
                    
            }
                
        }        

        return redirect('/Correo')->with('message','sended'); 
    }

    public function send2(Request $request)
    {
        $correo = Correo::find($request->emailid);
        
   
        
        $fecha = $correo->id_proceso;
        //$mensaje = $request->mensaje;
        $consultorcheck = $request->consultores;
        $clientescheck = $request->clientes;
        

        $empresas = DB::select(DB::raw("Select DISTINCT id_empresa  from Evaluacion INNER JOIN Requisitos on Evaluacion.id_Requisitos = Requisitos.id where Evaluacion.fecha_prox ='".$fecha."' " ));



        foreach($empresas as $empresa)
        {       

            if($consultorcheck != null and $consultorcheck == "true")
            {
                $usuarios = Usuario::where('EmpresasPermiso','LIKE','%'.$empresa->id_empresa.'%')->where('rol_id','=',2)->get();

                foreach($usuarios as $usuario)
                {
       
                    //echo "try";
                    //echo $usuario->idusuario;

                    $usuarionombre = $usuario->nombre;
                    $empresanombre = Empresa::where('idempresa','=',$empresa->id_empresa)->value('nombre');
                    $permisos = MailPermission::where("empresa",'=',$empresa->id_empresa)->first();         


                    if($permisos != null)
                    {                                  

                        $user_array = explode(",", $permisos->usuarios);
                        


                        if(in_array($usuario->idusuario,$user_array))
                        {


                            Mail::send(array(), array(), function ($message) use ($request,$usuario) {
                                  $message->to($usuario->correo)
                                    ->subject("Notifiación reqlegal")            
                                    ->setBody($request->html, 'text/html');
                                });

                            $correo->emisor = Auth::user()->idusuario;
                            //$correo->receptor = $usuario->idusuario;
                            $correo->html = $request->html;
                            $correo->asunto = "Notificación de vencimiento de correos";
                            $correo->estado = 2;
                            $correo->receptor = $usuario->idusuario;
                            $correo->save();
                            /*Mail::send('Mail.layout.mail2',compact('usuarionombre','fecha','mensaje','empresanombre'), function($msj) use ($usuario)
                            {
                                $msj->subject("Notificación reqlegal");
                                $msj->to($usuario->correo); 
                            });*/
                        }
                        
                    }    
                }
                /*print_r($usuario);
                               echo "empresas";
                            //print_r($permisos);

                            return ""; */
            }

            if($clientescheck != null and $clientescheck=="true")
            {
                //return "llegue a clientes";
                $usuarios = Usuario::where('EmpresasPermiso','LIKE','%'.$empresa->id_empresa.'%')->where('rol_id','=',3)->get();
                foreach($usuarios as $usuario)
                {
                    $usuarionombre = $usuario->nombre;
                    $empresanombre = Empresa::where('idempresa','=',$empresa->id_empresa)->value('nombre');
                    $permisos = MailPermission::where("empresa",'=',$empresa->id_empresa)->first();
                    if($permisos != null)
                    {
                        $user_array = explode(",", $permisos->usuarios);
                        if(in_array($usuario->idusuario,$user_array))
                        {
                            Mail::send(array(), array(), function ($message) use ($request,$usuario) {
                                  $message->to($usuario->correo)
                                    ->subject("Notifiación reqlegal")            
                                    ->setBody($request->html, 'text/html');
                                });

                            $correo->emisor = Auth::user()->idusuario;
                            //$correo->receptor = $usuario->idusuario;
                            $correo->html = $request->html;
                            $correo->asunto = "Notificación de vencimiento de correos";
                            $correo->estado = 2;
                            $correo->receptor = $usuario->idusuario;
                            $correo->save();

                            /*Mail::send('Mail.layout.mail2',compact('usuarionombre','fecha','mensaje','empresanombre'), function($msj) use ($usuario)
                            {
                                $msj->subject("Notificación reqlegal");
                                $msj->to($usuario->correo); 
                            });*/
                         }
                    }        
                }   
            }            
            
        }

       
        //return view('Mail.layout.mail2',compact('usuario','fecha','mensaje'));        

        return redirect('/Correo')->with('message','sended'); 
       
    }

    private function validateDate($date, $format = 'Y-m-d H:i:s')
	{
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}


    public function permission()
    {
        $action = new asignar_permisos_correo();   
        Session::put('current_action',$action);             
        $empresas=Empresa::All();
        return view("Mail.permissions",compact('empresas'));
    }

    public function assign_permission(Request $request)
    {
       $permisos = new MailPermission();
       $checked_values = " ";
       foreach($_POST as $key => $temp)
       {
            if(is_numeric($temp) and $key != "enterprise")
            {
                $checked_values .= " ".$temp.",";
            }
       }

       $checked_values = substr($checked_values, 0, -1);       

       $existence = $permisos::where('empresa','=',$request->enterprise)->first();

       if($existence != null)
       {
         $permisos = $existence;
         $permisos->empresa = $request->enterprise;
         $permisos->usuarios = $checked_values;   
         $permisos->save();
       }
       else
       {
         $permisos->empresa = $request->enterprise;
         $permisos->usuarios = $checked_values;        
         $permisos->save(); 
       }

       

       return redirect('/Correo')->with('message','assigned_permission'); 
    }

    public function emailbox()
    {
        return view('Mail.mailbox');
    }

    public function testmail(Request $request)
    {
        Mail::send(array(), array(), function ($message) use ($request) {
          $message->to($request->receptor)
            ->subject("Notificación de sig")            
            ->setBody($request->html, 'text/html');
        });
    }

    public function info_plantilla_requisitos(Request $request)
    {
        //print_r($_POST);
        $registros = DB::select(DB::raw("Select r.id as id , tp.nombre  as tpnorma, n.numero as norma ,a.numero as articulo from Requisitos as r inner join Evaluacion as e on r.id = e.id_Requisitos
         inner join Articulos as a on r.id_Articulos = a.id inner join Normas as n on a.id_Normas = n.id inner join Tipo_norma as tp
         on n.id_Tipo_norma = tp.id where e.fecha_prox = '".$request->fecha."'  and id_empresa = ".$request->empresa));
        

        return view("Mail.layout.mail2",compact('registros'));
    }

}
