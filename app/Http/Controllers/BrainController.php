<?php

namespace Sig\Http\Controllers;

use Illuminate\Http\Request;

use Sig\Models\Requisitos;

use Sig\Models\Year;

use Sig\Models\Articulos;

use Sig\Models\Empresa;

use Sig\Models\Evaluacion;

use Sig\Models\HtmlHelper;

use Sig\Helpers\Externclass;

use Session;

use Auth;

use DB;

class BrainController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function test()
    {
    	$years = Year::OrderBy('year')->get();
    	echo json_encode($years);
    }

    public function verify_duplicy_by_enterprise()
    {
        $query = "SELECT e.nombre as empresa, id_empresa, id_Articulos, id_Literales , a.numero as articulo, n.numero as norma,
                        tp.nombre as tipo_norma,  COUNT(id_Articulos) as CNT
        FROM
            Requisitos as r inner join empresa as e on r.id_empresa = e.idempresa inner join 
                        Articulos as a on a.id = r.id_Articulos inner join Normas as n on a.id_Normas = n.id
                        inner join Tipo_norma as tp on tp.id = n.id_Tipo_norma
        GROUP BY id_empresa ,id_Articulos , id_Literales
        HAVING CNT > 1";
        $registros = DB::select(DB::raw($query));

        //$empresas = Empresa::lists('nombre','idempresa');
        //$articulos = Articulos::lists('numero','id');  

        return view('Asistant.duplicate_records',compact('registros','empresas','articulos'));
    }

    public function verify_first_asistant_view()
    {
        $response =  array('status'=>"",'view'=>"js/Views/Modals/Notification3.html","type"=>"automatic_repair");

        $verify = HtmlHelper::where('user','=',Auth::user()->idusuario)->where('type','=','automatic_repair')->where('status','=','watched')->first();
        if($verify == null)
        {
            $response['status'] = "not done";    
        }
        else
        {
            $response['status'] = "done";
        }



         echo json_encode($response);  
    }

    public function verify_first_asistant_view_watched(Request $request)
    {
       // echo "soy sesion ".Auth::user()->idusuario." ".$request->type;
        $html = new HtmlHelper();
        $html->id = Externclass::id_generator($html,'id');
        $html->type = $request->type;
        $html->status = 'watched';
        $html->user = Auth::user()->idusuario;
        $html->save();
    }

    public function repair_reqs(Request $request)
    {
        $requisito =  Requisitos::where('id','=',$request->id)->first();
        $evals = Evaluacion::where('id_Requisitos','=',$requisito->id)->get();
        
        //print_r($registro);
        
        $query = "Select * from Requisitos where id_Articulos = ".$requisito->id_Articulos." and id_empresa = ".$requisito->id_empresa." and id_Literales is null ";
        $registros = DB::select(DB::raw($query));
              
        
        foreach($registros as $registro)
        {
            if($requisito->id != $registro->id)
            {
                $requisito->reqlegal = $requisito->reqlegal." ".$registro->reqlegal;
                $requisito->esperada = $requisito->esperada." ".$registro->esperada; 
                $requisito->responsable = $requisito->responsable." ".$registro->responsable; 
                $evaluaciones = Evaluacion::where('id_Requisitos','=',$registro->id)->get();
                if(count($evals)>0)
                {
                    foreach ($evals as $eval) {

                        foreach($evaluaciones as $evaluacion)
                        {
                            if($eval->fecha_prox == $evaluacion->fecha_prox)
                            {
                                 if($eval->id < $evaluacion->id)
                                 {
                                    DB::delete("delete from Evaluacion where id = ".$eval->id);
                                    $evaluacion->id_Requisitos = $requisito->id;
                                    $evaluacion->save();  
                                 }
                                 else
                                 {
                                    DB::delete("delete from Evaluacion where id = ".$evaluacion->id);
                                 }
                            }
                            else
                            {
                                $evaluacion->id_Requisitos = $requisito->id;
                                $evaluacion->save();    
                            } 
                                    
                                
                        }
                    }
                }
                else
                {
                    foreach($evaluaciones as $evaluacion)
                    {
                        
                            $evaluacion->id_Requisitos = $registro->id;
                            $evaluacion->save();                    
                            
                    }
                }
                
                
                
                DB::delete("delete from Requisitos where id = ".$registro->id);       
            }
        }

        $requisito->save();

    }

    public function automatic_repair()
    {
       ini_set('max_execution_time', 500);
       $query = "select (select count(DISTINCT(Articulos.id)) from Requisitos inner join Articulos on Articulos.id = Requisitos.id_Articulos where Articulos.numero = a.numero and Articulos.id_Normas = a.id_Normas and Requisitos.id_empresa = r.id_empresa and Requisitos.id_Literales is null ) as CNT, r.id,a.id as id_articulo , r.id_empresa as id_empresa, a.numero as articulo,a.id_Normas,r.id_Literales from Requisitos as r inner join Articulos as a on r.id_Articulos = a.id  where r.id_Literales is null HAVING CNT > 1 order by id_empresa,id_Normas,numero,id_Articulos ";
       $registros = DB::select(DB::raw($query));
       $total = count($registros);
       $current_reg = null;
       foreach($registros as $registro)
       {
            if($current_reg == null)
            {
                $current_reg = $registro;
            }
            else
            {
                //echo $registro->id.":".$current_reg->id;
                //echo "<br>"; 
                if($registro->articulo = $current_reg->articulo and $registro->id_Normas = $current_reg->id_Normas and $registro->id_articulo != $current_reg->id_articulo)
                {
                    
                    $evals = Evaluacion::where('id_Requisitos','=',$registro->id)->get();
                    
                    $evaluaciones = Evaluacion::where('id_Requisitos','=',$current_reg->id)->get();

                    if(count($evals)>0)
                    {
                        foreach ($evals as $eval) {

                            foreach($evaluaciones as $evaluacion)
                            {
                                if($eval->fecha_prox == $evaluacion->fecha_prox)
                                {
                                    //echo "here same" ;
                                     if($eval->id < $evaluacion->id)
                                     {
                                        DB::delete("delete from Evaluacion where id = ".$eval->id);
                                        $evaluacion->id_Requisitos = $registro->id;
                                        $evaluacion->save();  
                                     }
                                     else
                                     {
                                        DB::delete("delete from Evaluacion where id = ".$evaluacion->id);
                                     }
                                }
                                else
                                {
                                    //echo "here";
                                    $evaluacion->id_Requisitos = $registro->id;
                                    $evaluacion->save();    
                                } 
                                        
                                    
                            }
                        }    
                    }
                    else
                    {
                        foreach($evaluaciones as $evaluacion)
                        {
                            
                                $evaluacion->id_Requisitos = $registro->id;
                                $evaluacion->save();                    
                                
                        }
                    }
                    
                    //echo "eliminar";
                    DB::delete("delete from Requisitos where id = ".$current_reg->id);
                    $current_reg = $registro;   
                }
                else
                {
                    $current_reg = $registro;   
                }

            }

            
         
       }

       return "Se repararon un total de ".$total." registros";
    }


}
