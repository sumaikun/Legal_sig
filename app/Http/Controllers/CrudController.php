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
                
                if(isset($request->Acc))
                {
                    $Acc = $request->Acc;
                    $response = $this->$Acc($request);
                    return $response;    
                }
                else
                {
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

    }


    public function get_from_table($request)
    {
        $SQL  = $request->query;    
        $results = DB::SELECT(DB::RAW($SQL));
        return response()->json(['results' => $results]);   
    }

    public function getAll($request)
    {    
        //$default_column = $this->DEFAULT_COLUMN($request);
        $default_column = false;
        if($default_column)
        {
            $sql = "Select * from ".$request->table." order by ".$default_column;
        }
        else
        {
            $sql = "Select * from ".$request->table;
        }

        $rows = DB::SELECT(DB::RAW($sql));        
        $array = array("status"=>1,"rows"=>$rows,"sql"=>$sql);
        return response()->json($array);
    }

    public function getBy($request)
    {
        $sql = "Select * from ".$request->table." where ";

        $properties = $request->properties;

        $i = 0;
        foreach($properties as $key => $value)
        {
            $i++;
            if(count($properties) == $i)
            {
                if(is_array($value))
                {
                    $inner =  '(';
                    foreach ($value as $val) {
                        $inner .= "'".$val."',";
                    }
                    $inner = substr($inner, 0,-1);
                    $inner .=  ')';
                    $sql .=  $key." in ".$inner;

                    //echo $sql;      
                }
                else
                {
                    $sql .=  $key." = '".$value."'";    
                }
                    
            }
            else
            {
                if(is_array($value))
                {
                    $inner =  '(';
                    foreach ($value as $val) {
                        $inner .= "'".$val."',";
                    }
                    $inner = substr($inner, 0,-1);
                    $inner .=  ')';
                    $sql .=  $key." in ".$inner;
                }
                else
                {
                    $sql .=  $key." = '".$value."' and ";    
                }

            }
        }

        $rows = DB::SELECT(DB::RAW($sql));
        
        $array = array("status"=>1,"rows"=>$rows,"sql"=>$sql);

        return response()->json($array);
        
    }

    private function DEFAULT_COLUMN($request)
    {
        if($request->table != "requisitos")
        { 
            $sql = "SHOW COLUMNS FROM ".$request->table;           
            $columns = DB::SELECT(DB::RAW($sql));
            foreach($columns as $column)
            {
                if(strpos($column->Type,"varchar") !== false )
                {
                    //echo "done";
                    return $column->Field;  
                }
            }
        }

        return false;   
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
        //$validation = $request->validation;
        if(isset($request->validation))
        { 

            foreach($request->validation as $validation)
            {
                if($validation->type = "edit_or_create" )
                {
                    $validate = $validation;
                    $validate->type = "existence_on_edit";
                    $f_validate = $this->process_validation($validate,$request);
                }

                else
                {
                    $f_validate = array("status"=>1);
                }
            }

            if($f_validate["status"]!= 1)
            {
                return response()->json($f_validate);
            }
        }                   

        $array = $request->data;

        $sql = $this->update($request->table,$array);
      
        DB::UPDATE(DB::RAW($sql));

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
        if(isset($request->validation))
        {
            foreach($request->validation as $validation)
            {
                if($validation->type = "edit_or_create" )
                {
                    $validate = $validation;
                    $validate->type = "existence_on_create";
                    $f_validate = $this->process_validation($validate,$request);
                }

                else
                {
                    $f_validate = array("status"=>1);
                }
            }
            
            if($f_validate["status"]!= 1)
            {
                return response()->json($f_validate);
            }    
        }
               

        $array = $request->data;

        $sql = $this->insert($request->table,$array);

        DB::insert(DB::RAW($sql));

        $array = array("status"=>1,"message"=>"Nuevo elemento insertado","sql"=>$sql);
        return response()->json($array);
    }

    private function delete_query($table,$array)
    {
        //DELETE FOREIGN DATA;

        $sql = "SHOW KEYS FROM ".$table." WHERE Key_name = 'PRIMARY' ;";           

        $m_metadata = DB::SELECT(DB::RAW($sql))[0];

        $sql = "SELECT * FROM  information_schema.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME = '".$table."'";           
        $referenced = DB::SELECT(DB::RAW($sql));

        if($referenced!= null)
        {
            foreach($referenced as $reference)
            {

                $sql = "Select * from ".$reference->TABLE_NAME." where ".$reference->COLUMN_NAME." = ".$array->id;

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

    private function safe_delete($table,$array)
    {
        $date = date('Y-m-d');
        $id = $this->id_column;
        $sql = "Update ".$table." set deleted_at = '".$date."' where ".$this->id_column."  = ".$array->$id;
        return $sql;
        

    }

    private function insert($table,$array)
    {
        
        
    
        $sql = "Insert into ".$table;
        $sql .= " (";
    
        
        foreach($array as $key => $value)
        {
            if($key != 'table' and $key != 'Acc' and $key != 'deleted_at')
            {
                $sql .= $key.",";
                
            }
    
            
        }
        $sql = substr_replace($sql, "", -1);
        $sql .= ") values ( ";
        
        foreach($array as $key => $value)
        {
            if($key != 'table' and $key != 'Acc' and $key != 'deleted_at')
            {
                $sql .= "'".$value."',";
                
            }
    
            
        }
        $sql = substr_replace($sql, "", -1);
        $sql .= ") ";       
        
        //echo $sql;

        //exit;

        return $sql;
    }
    
    
    private function update($table,$array)
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


    private function process_validation($validation,$request)
    {

        switch($validation->type)
        {
            case "FOREIGN_VALUES":
                $sql = "SELECT * from  $validation->with where $validation->foreign_key = ".$request->data->id." ";               
                $result = DB::SELECT(DB::RAW($sql));
                if($result)
                {
                    $n = count($result);   
                }
                else{
                    $n = 0;
                }   
                if($n > 0)
                {
                   $array = array("status"=>2,"message"=>"Existen valores relacionados a este tabla que impiden su eliminación");
                }               
                break;
            case "existence_on_edit":
                $sql = "Select * from ".$request->table." where ";
                $count = 1;
                foreach($validation->columns as $column)
                {
                    if($count!=count($validation->columns))
                    {                        
                        $sql .= $column." = '".$request->data->$column."'  and ";
                    }
                    else
                    {
                        $sql .= $column." = '".$request->data->$column."'";
                    }                    
                    $count++;
                }        

                $result = DB::SELECT(DB::RAW($sql));      

                if(isset($result[0]))
                {
                    if($result[0]->id != $request->data->id || count($result)>1)
                    {
                        $array = array("status"=>2,"message"=>"Existen valores similares en la base de datos por favor revise los datos enviados para evitar el ingreso de un registro repetido");
                    }
                    else
                    {
                        $array = array("status"=>1);   
                    }    
                }
                else
                {
                    $array = array("status"=>1);    
                }                
                break;
            case "existence_on_create":
                    $sql = "Select * from ".$request->table." where ";
                    $count = 1;
                    foreach($validation->columns as $column)
                    {
                        if($count!=count($validation->columns))
                        {
                            $sql .= $column." = '".$request->data->$column."'  and ";
                        }
                        else
                        {
                            $sql .= $column." = '".$request->data->$column."'";
                        }                    
                        $count++;
                    }

                    //echo $sql;

                    $result = DB::SELECT(DB::RAW($sql));


                    
                    if(count($result)>0)
                    {
                        
                        $array = array("status"=>2,"message"=>"Ya hay un registro igual en la base de datos");
                    }
                    else
                    {
                        $array = array("status"=>1);    
                    }                    
            break;    
            default:
                $array = array("status"=>1);
                break;
        }
        
       //print_r($array);
       return $array;
    }

    public function foreign_data($request)
    {
        $sql = "SELECT  TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME, REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
        WHERE  COLUMN_NAME = '".$request->column."' AND TABLE_NAME = '".$request->table."'";
        $f_data = DB::SELECT(DB::RAW($sql));
        $array = array("status"=>1,"sql"=>$sql,"f_data"=>$f_data);
        return response()->json($array);

    } 
    


}
