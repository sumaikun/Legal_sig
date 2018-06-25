<?php

namespace Sig\Http\Controllers;

use Illuminate\Http\Request;
use Sig\Comentario;
use Sig\Http\Requests;
use Sig\Http\Controllers\Controller;
use Sig\Rol;
use Sig\Evaluacion;
use \Storage;
use Auth;
use Mail;
use Carbon\Carbon;
use Cache;
use Sig\Helpers\Externclass;
use Sig\Helpers\Validation;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
       public function __construct()
    {
        $this->middleware('auth');
    }
    





    public function index()
    {

    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {  /* $now =\Carbon\Carbon::now()->format('d/m/Y H:i:s');
        dd($now);*/

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
        

        $comentario = $request->comentario;
        $evaluacion = $request->idevaluacion;
        $usuario = Auth::user()->idusuario;
        $archivo = $request->file('archivo');
        


        if($archivo!=null)
        {     
            $nombre_original=$archivo->getClientOriginalName();        
            $datos_validar = ["comentario"=>$comentario,"evaluacion"=>$evaluacion,"usuario"=>$usuario,"archivo"=>$nombre_original];
           // return  $datos_validar;
            $upload=Storage::disk('adjuntos')->put($nombre_original,  \File::get($archivo) );
            if($upload){
                //return "este es el usuario ".$usuario;
                    Comentario::create([
                        'evaluacion_id'=>$evaluacion,
                        'usuario_id' =>$usuario,
                        'comentario' =>$comentario,
                        'archivo' =>$nombre_original,
                    ]);

                }
        }   
        else {
            Comentario::create([
                    'evaluacion_id'=>$evaluacion,
                    'usuario_id' =>$usuario,
                    'comentario' =>$comentario,
                    'archivo' =>'N.A',
                ]);            
        }

            $idcomentario = Comentario::lists('id')->last();

            Validation::timing($idcomentario,Auth::user()->idusuario);

            echo '<span class="proce">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspComentario registrado dispone de 30 minutos para editarlo</span>';

            $empresa = Evaluacion::Where('id','=',$request->idevaluacion)->value('empresa');

            $empresa = Externclass::corp_name($empresa);

            $requisito = Externclass::req_data(Externclass::eval_req($request->idevaluacion));

            $Fecha2 = Externclass::evaluation_date($request->idevaluacion);

            $mytime = Carbon::now();
            $Fecha = $mytime->format('d-m-Y'); 
            $array = array('Fecha'=>$Fecha,'nombre'=>Auth::user()->nombre,'mensaje'=>$comentario,'requisito'=>$requisito,'empresa'=>$empresa,'Fecha2'=>$Fecha2);

            //return view('emails.comentario',compact('array'));

            Mail::send('emails.comentario',$array,function($msj){
            $msj->from('us@sig.com', 'Grupo-Sig');
            $msj->subject('Comentario de requisito legal');
            $msj->to('consultorialegal@grupo-Sig.com');
            });

    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $cmt =Comentario::find($id);
        return view('admin.editcomentario',['cmt'=>$cmt]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Cache::get($id)!=null)
        {   $comentario = Comentario::find($id);
            return view('Comentario.editarcomentario',compact('comentario','id'));
        }   
        else {

            return '<span class="proce">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspNo puede editarse</span>';    
         }
       

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $archivo = $request->file('archivo');
        $comentario = Comentario::find($request->id);
        $table = new Comentario();
                $property = 'id';
                $argument = $request->id;
                $file = 'archivo';

        Externclass::deletefiles($table,$property,$argument,$file,'adjuntos');
        if($archivo!=null)
        {     
           
            $nombre_original=$archivo->getClientOriginalName();
            $name = Carbon::now()->second.$nombre_original;    
            $upload=Storage::disk('adjuntos')->put($name,  \File::get($archivo) );
            if($upload){  
              $comentario ->fill(['archivo'=>$nombre_original,]);
            } 
        }
        else
        {
            $comentario ->fill(['archivo'=>'N.A',]);
        }    
        $comentario -> fill(['comentario'=>$request->comentario,'evaluacion_id'=>$request->idevaluacion,'usuario_id'=>Auth::user()->idusuario,]);
        $comentario -> save();
        echo '<span class="proce">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspComentario editado</span>';

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function downloadfile($file)
    {
            $file_path = storage_path('comentarios/'.$file);
            return response()->download($file_path); 
    }
}
