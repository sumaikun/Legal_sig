<?php

namespace Sig\Console\Commands;

use Illuminate\Http\Request;

use Illuminate\Console\Command;

use Illuminate\Foundation\Inspiring;

use Sig\Http\Requests;

use Sig\MigracionMatriz;

use Sig\Historicom;

use Sig\Evaluacion;

use Sig\Empresa;

use Mail;

use Carbon;

use Sig\Usuario;

use Sig\Rol;

use App;

use DB;

use Sig\Helpers\Externclass;

use Sig\Helpers\ControladorHistoricos; 


class emailFechas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:fechas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send an email when the time of make an evaluation is running out';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {         

        $roles = Rol::lists('nombre','idrol');
         $usuarios = Usuario::All();
         $empresas = Empresa::lists('nombre','idempresa');
         //$historicos = Externclass::norepeathistoricos();
         //return $historicos;
         $historicos = Historicom::All();

         foreach ($historicos as $historico)
         {
             //echo "historico: ".$historico;

                $migracion = MigracionMatriz::Where('id_historico','=',$historico->id)->first();
                $mytime = Carbon\Carbon::now();
                $hoy = $mytime->format('Y-m-d');

                //$evaluacion = Evaluacion::Where('id','=',$migracion->id_evaluacion)->first();
                $fecha2 = floor(strtotime($historico->fechaprox)/(60*60*24));
                $fecha = floor(strtotime($hoy)/(60*60*24));  
                
               // $fecha = floor(strtotime($evaluacion->Fecha)/(60*60*24));
                $operacion=$fecha2-$fecha;
                //echo $operacion;
                //echo '<br>';
                if($operacion<=10)
                {
                    foreach ($usuarios as $usuario)
                     {   

                        if($usuario->rol_id!=1&&$usuario->EmpresasPermiso!="ninguna")
                        {  
                            $logo = Empresa::Where('idempresa','=',$historico->empresa_id)->value('path');
                             $arreglo = explode(",",$usuario->EmpresasPermiso);
                              if(in_array($historico->empresa_id, $arreglo))
                                { 
                                 $requisitos= DB::select(DB::raw("Select RequisitosMatriz.id , RequisitosMatriz.TipoNorma , RequisitosMatriz.Numero , RequisitosMatriz.ArticuloAplica , HistoricoMigracion.empresa_id , HistoricoMigracion.ambiental , HistoricoMigracion.id as historic  from RequisitosMatriz INNER JOIN MigracionMatriz on RequisitosMatriz.id = MigracionMatriz.id_requisito  INNER JOIN HistoricoMigracion on MigracionMatriz.id_historico = HistoricoMigracion.id Where HistoricoMigracion.id =".$historico->id.";"));  
                                 $requisitos = ControladorHistoricos::inactive($requisitos);
                                 if ($requisitos != null)
                                 {
                                    
                                     $array = array('tiempo' =>$operacion,'titulo' =>$historico->nombre,'nombre'=>$usuario->nombre,'rol'=>$roles[$usuario->rol_id],'empresa'=>$empresas[$historico->empresa_id],'logo'=>$logo); 
                                     //return view('emails.email',compact('array','requisitos'));
                                     Mail::send('emails.email',compact('array','requisitos'),function($msj) use ($usuario){
                                        $msj->from('Grupo@sig.com', 'Grupo-Sig');
                                        $msj->subject('alertas requisitos legales');
                                        $msj->to('alejito352@hotmail.com');
                                       // $msj->to($usuario->correo); 
                                    });
                                 }
                                 
                               }
                        }  
                     }                  
                }    
                
                //echo "operacion: ".$operacion;
            
         }   

        return "mensaje enviado";
        

    }
}
