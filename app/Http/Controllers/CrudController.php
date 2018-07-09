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

class CrudController extends Controller
{
    public function __construct()
    {
        $this->id_column = "id";
    }

    public function dispatcher(Request $request)
    {
        if($_REQUEST)
        {
            if(isset($_REQUEST['Acc']))
            {                
                $request = (object)$_REQUEST;

                $Acc = $request->Acc;

                $response = $this->$Acc($request);

                return $response;
               
            }


        }
        else
        {
            //echo "GOT HERE ".$_SERVER['REQUEST_METHOD'];
            $request_body = file_get_contents('php://input');
            if($request_body)
            {
                $request = json_decode($request_body);  
                
                
                switch ($_SERVER['REQUEST_METHOD']) {
                    case "POST":
                        $response = $this->create($request);
                        break;
                    case "PUT":             
                        $response = $this->persist($request);
                        break;
                    case "DELETE":
                        //echo "here";
                        $response = $this->delete($request);
                        break;
                }       
                
                return $response;
            }       
            

        }

    }


    public function get_from_table($request)
    {
        $SQL  = $request->query;    
        $results = DB::SELECT(DB::RAW($SQL));
        return response()->json(['results' => $results]);   
    }

    public function getAll($request)
    {    
        $sql = "Select * from ".$request->table;     
        $rows = DB::SELECT(DB::RAW($sql));        
        $array = array("status"=>1,"rows"=>$rows,"sql"=>$sql);
        return response()->json($array);
    }


    public function META_COLUMNS($request)
    {
        $sql = "SHOW COLUMNS FROM ".$request->table;           
        $columns = DB::SELECT(DB::RAW($sql));        
        $array = array("status"=>1,"columns"=>$columns,"sql"=>$sql);
        return response()->json($array);
    }



    public function persist($request)
    {       
        $array = $request->data;

        $sql = $this->update($request->table,$array);
      
       
       $array = array("status"=>1,"sql"=>$sql);
       return response()->json($array);
    }

    public function delete($request)
    {

        $array = $request->data;

        if($request->safe_table == true)
        {
            $sql = $this->safe_delete($request->table,$array);
        }
        else
        {
            $sql = $this->delete_query($request->table,$array);
        }        
      
        $array = array("status"=>1,"sql"=>$sql);

        DB::DELETE(DB::RAW($sql));

        return response()->json($array);  

    }

    public function create($request)
    {
        $array = $request->data;

        $sql = $this->insert($request->table,$array);

        $array = array("status"=>1,"message"=>"Nuevo elemento insertado","sql"=>$sql);
        return response()->json($array);
    }

    public function delete_query($table,$array)
    {
        //DELETE FOREIGN DATA;

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
                        
                        $sql = "DELETE FROM ".$reference->TABLE_NAME." WHERE ".$f_metadata->Column_name." = ".$result->$Column_name;    
                        
                        DB::DELETE(DB::RAW($sql));                        
                    }
                }
            }
        }

        //DELETE FOREIGN DATA


        $id = $this->id_column;
        $sql = "DELETE from ".$table." where ".$this->id_column."  = ".$array->$id;     
        return $sql;
        

    }

    public function safe_delete($table,$array)
    {
        $date = date('Y-m-d');
        $id = $this->id_column;
        $sql = "Update ".$table." set deleted_at = '".$date."' where ".$this->id_column."  = ".$array->$id;
        return $sql;
        

    }

    public function insert($table,$array)
    {
        
        
    
        $sql = "Insert into ".$table;
        $sql .= " (";
    
        
        foreach($array as $key => $value)
        {
            if($key != 'table' and $key != 'Acc')
            {
                $sql .= $key.",";
                
            }
    
            
        }
        $sql = substr_replace($sql, "", -1);
        $sql .= ") values ( ";
        
        foreach($array as $key => $value)
        {
            if($key != 'table' and $key != 'Acc')
            {
                $sql .= "'".$value."',";
                
            }
    
            
        }
        $sql = substr_replace($sql, "", -1);
        $sql .= ") ";       
        
        return $sql;
    }
    
    
    public function update($table,$array)
    {

        $sql = "update ".$table;
        $sql .= " SET ";
    
        
        foreach($array as $key => $value)
        {
            
            if($key == $this->id_column)
            {
                $id = $value;
            }
            else
            {
                if($key != 'table' and $key != 'Acc')
                {
                    $sql .= $key."  = '".$value."',";
                    
                }
            }
            
        }   

        $sql = substr_replace($sql, "", -1);    
        
        $sql .= " where ".$this->id_column." = ".$id;           
        
        return $sql;
    }

    public function process_validation($validation)
    {           
        /*switch($validation->type)
        {
            case "FOREIGN_VALUES":
                $sql = "SELECT * from  $validation->with where $validation->foreign_key = ".$request->data->id." ";               
                $result = $this->query($sql);
                if($result)
                {
                    $n = mysql_num_rows($result);   
                }
                else{
                    $n = 0;
                }   
                if($n > 0)
                {
                   $array = array("status"=>2,"message"=>"Existen valores relacionados a este tabla que impiden su eliminación");
                }               
                break;
            default:
                break;
        }
        
       $array = array("status"=>1);
       return response()->json($array);*/
    }

    public function foreign_data($request)
    {
        $sql = "SELECT  TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME, REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
        WHERE  COLUMN_NAME = '".$request->column."'";
        $f_data = DB::SELECT(DB::RAW($sql));
        $array = array("status"=>1,"sql"=>$sql,"f_data"=>$f_data);
        return response()->json($array);

    } 
    


}
