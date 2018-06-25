<?php

namespace Sig\Http\Controllers;

use Illuminate\Http\Request;

use Sig\Http\Requests;

use Sig\Http\Controllers\ToolController; 

use DB;

use Session;

use Auth;

class SystemController extends Controller
{
    public function __construct()
    {
        
    }


    public function user_session()
    {
       $user_properties = new \stdClass();

       if(Auth::user()->idusuario != null)
       {
            $user_properties->iduser = Auth::user()->idusuario;
            $user_properties->rol = Auth::user()->rol_id;
            $user_properties->nombre = Auth::user()->nombre;

            $array = array("status"=>1,"message"=>"Conseguida variables de sesión","user_properties"=>$user_properties); 
       }
       else
       {
            $array = array("status"=>3,"message"=>"No se puede iniciar sesión");
       }

       return response()->json($array);
       
    }

    public function delete_replace(Request $request)
    {
  		if($request->id == $request->foid)
  		{
  			$array = array("status"=>2,"message"=>"No se puede reemplazar por el mismo");
            return response()->json($array);
  		}

  		$sql = "SHOW KEYS FROM ".$request->table." WHERE Key_name = 'PRIMARY' ;";			

		$m_metadata = DB::SELECT(DB::RAW($sql))[0];

		$sql = "SELECT * FROM  information_schema.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME = '".$request->table."'";           
        $referenced = DB::SELECT(DB::RAW($sql));
        if($referenced!= null)
        {
        	foreach($referenced as $reference)
        	{

        		$sql = "Select * from ".$reference->TABLE_NAME." where ".$reference->COLUMN_NAME." = ".$request->id;

        		$resultdata = DB::SELECT(DB::RAW($sql));

        		$sql = "SHOW KEYS FROM ".$reference->TABLE_NAME." WHERE Key_name = 'PRIMARY' ;";			

        		$f_metadata = DB::SELECT(DB::RAW($sql))[0];

        		if($resultdata != null)
        		{
        			foreach($resultdata as $result)
        			{
        				$Column_name = $f_metadata->Column_name;
        				
        				$sql = "UPDATE ".$reference->TABLE_NAME." SET ".$reference->COLUMN_NAME." = ".$request->foid." WHERE ".$f_metadata->Column_name." = ".$result->$Column_name;	
						
						//DB::UPDATE(DB::RAW($sql));        				
        			}
        		}
        	}
        }

        $Column_name = $m_metadata->Column_name;

        $sql = "DELETE FROM ".$request->table." where ".$m_metadata->Column_name." = ".$request->id;

        //DB::DELETE(DB::RAW($sql));

        $array = array("status"=>1,"message"=>"Registro eliminado");
        return response()->json($array);
        
        
    }


    public function derogar(Request $request)
    {
        if($request->foid == $request->id)
        {
            $array = array("status"=>3,"message"=>"Ocurrio un inconveniente en el proceso");
        }

        $tcon = new ToolController();

        if(strtoupper($request->table) == "NORMAS")
        {
            $process = $tcon->derogar_norma($request->foid,$request->id);
        }

        if(strtoupper($request->table) == "ARTICULOS")
        {
            $process = $tcon->derogar_articulo($request->foid,$request->id);   
        }

        if(strtoupper($request->table) == "LITERALES")
        {
            $process = $tcon->derogar_literal($request->foid,$request->id);   
        }

        if($process == "Derogacion exitosa")
        {
            $array = array("status"=>1,"message"=>"Prueba derogar");    
        }

        else
        {
            $array = array("status"=>3,"message"=>"Ocurrio un inconveniente en el proceso");
        }

        
        return response()->json($array); 
    }

    public function desderogar(Request $request)
    {
        $tcon = new ToolController();

        if(strtoupper($request->table) == "NORMAS")
        {
            $process = $tcon->anular_derogar_norma($request->id);
        }

        if(strtoupper($request->table) == "ARTICULOS")
        {
            $process = $tcon->anular_derogar_articulo($request->id);   
        }

        if(strtoupper($request->table) == "LITERALES")
        {
            $process = $tcon->anular_derogar_literal($request->id);   
        }

        if($process == "derogación anulada")
        {
            $array = array("status"=>1,"message"=>"Prueba desderogar");    
        }

        else
        {
            $array = array("status"=>3,"message"=>"Ocurrio un inconveniente en el proceso");
        }

        
        return response()->json($array);   
    }

    public function derogar_info(Request $request)
    {
        $tcon = new ToolController();

        if(strtoupper($request->table) == "NORMAS")
        {
            $process = $tcon->derogar_info($request->id);
        }

        if(strtoupper($request->table) == "ARTICULOS")
        {
            $process = $tcon->derogar_info_2($request->id);   
        }

        if(strtoupper($request->table) == "LITERALES")
        {
            $process = $tcon->derogar_info_3($request->id);   
        }
        
        $array = array("status"=>1,"message"=>$process);
        
        return response()->json($array);   
    }
}
