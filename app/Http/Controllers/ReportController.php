<?php

namespace Sig\Http\Controllers;

use Illuminate\Http\Request;
use Sig\Http\Requests;
use Sig\RequisitosMatriz;
use Sig\Models\Empresa;
use Sig\Helpers\Permission;

use Auth;

use DB;

class ReportController extends Controller
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




    public function last_updated()
    {

    	$data =  [];

    	$empresas = Empresa::All();

    	foreach($empresas as $empresa)
    	{
    		$date = RequisitosMatriz::where('empresa','like','%'.$empresa->idempresa.'%')->orderBy('id','desc')->first();
    		$elem = array("empresa" => $empresa->nombre, "fecha" => $date['updated_at']);
    		array_push($data, $elem);
    	}

    	return view('Reports.last_updated',compact('data'));
    	
    }

    public function graficas()
    {
        $empresas = $this->empresas;
        return view('Matriz.Charts.chart1',compact('empresas'));
    }

    public function draw_g($empresa,$tipo)
    {
        if($tipo == 1)
        {
            $total100 = DB::SELECT(DB::RAW("select COUNT(r.id) as total from Requisitos as r INNER JOIN Evaluacion as e on e.id_Requisitos = r.id where calificacion = 100 and r.id_empresa = ".$empresa." ;"));
            $total0 = DB::SELECT(DB::RAW("select COUNT(r.id) as total from Requisitos as r INNER JOIN Evaluacion as e on e.id_Requisitos = r.id where calificacion = 0 and r.id_empresa = ".$empresa." ;"));

            $total100 = $total100[0]->total;

            $total0 = $total0[0]->total;

            $total_todo = $total100 + $total0;

            if($total_todo == 0)
            {
                $total_todo = 1;   
            }

            $total100 = ($total100*100)/$total_todo;

            if($total100 == 100)
            {
               $total100 = 99.9;   
            }

            $total0 = ($total0*100)/$total_todo;          

            if($total0 == 100)
            {
               $total0 = 99.9;   
            }

            $array = [];

            $first = array("x" => "10", "y" => $total100, "label" => '100 %');

            array_push($array, $first);

            $second = array("x" => "20", "y" => $total0, "label" => '0 %'); 

            array_push($array, $second);

            return $array;    
        }
        if($tipo == 2)
        {
            $factores =  DB::select(DB::RAW("select  DISTINCT f.nombre as nombre, ( select COUNT(*) from Requisitos inner JOIN Categorias on Categorias.id = Requisitos.id_Categorias INNER JOIN Factores on Factores.id = Categorias.id_Factores INNER JOIN Evaluacion on Evaluacion.id_Requisitos = Requisitos.id where Factores.nombre = f.nombre and Calificacion = 100) as total, ( select COUNT(*) from Requisitos inner JOIN Categorias on Categorias.id = Requisitos.id_Categorias INNER JOIN Factores on Factores.id = Categorias.id_Factores INNER JOIN Evaluacion on Evaluacion.id_Requisitos = Requisitos.id where Factores.nombre = f.nombre and Calificacion = 0) as total2  from Requisitos as r INNER JOIN Evaluacion as e on e.id_Requisitos = r.id INNER JOIN Categorias as c on r.id_Categorias = c.id INNER JOIN Factores as f on f.id = c.id_Factores where calificacion = 100 and  r.id_empresa = ".$empresa." ;  "));

            $array = [];

            foreach ($factores as $factor)
            {
                static $cont = 10;
                $total_todo = $factor->total + $factor->total2;
                if($total_todo == 0)
                {
                    $total_todo = 1;   
                }
                $total100 = ($factor->total*100)/$total_todo;                
                if($total100 == 100)
                {
                   $total100 = 99.9;   
                }
                $first = array("x" =>$cont , "y" => $total100, "label" => $factor->nombre);
                array_push($array, $first);
                $total0 = ($factor->total2*100)/$total_todo;
                if($total0 == 100)
                {
                   $total0 = 99.9;   
                }
                $cont = $cont + 10;
                $second = array("x" =>$cont , "y" => $total0, "label" => $factor->nombre); 
                array_push($array, $second);
                $cont = $cont + 10;               
            }

            return $array;
        }                

    }

   
}
