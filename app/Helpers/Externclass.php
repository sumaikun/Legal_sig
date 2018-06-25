<?php	
namespace Sig\Helpers;
//use App\Providers\AppServiceProvider;
use App;

use Sig\Evaluacion;

use Sig\ClaseNorma;
use Sig\Models\Empresa;
use Sig\Models\Usuario;
use Sig\RelacionHis;
use Sig\Normas;
use Sig\TipoNorma;
use Sig\Articulos;
use Sig\Models\Documento;
use DB;
use Carbon;
use Auth;
use Storage;

class Externclass {

	function __construc(){}

	public static function prueba($test)
	{
		return $test;
	}

  public static function doc_name($id)
  {
    $nombre = Documento::where('id','=',$id)->value('nombre');
    return $nombre;
  } 

	public static function cleanarray($arrays,$property,$comparison)
	{
		$numeros = Array();
      

        $count = count($arrays);
         for ($i=0 ; $i<$count ;$i++)
         {
           foreach ($arrays as $array)
           {
            if($arrays[$i]->id!=$array->id )
            {
                if($arrays[$i]->$property == $array->$property)
                {   

               
                   if($array->$comparison>$arrays[$i]->$comparison)
                   {
                      array_push($numeros, $i);  
                      
                   }
                }
            }
           }
         }
         foreach ($numeros as $numero)
         {    
            unset($arrays[$numero]);
         }      
        
        return $arrays;
	}

  public static function get_norma_from_articulo($id)
  {

    $norma_id = Articulos::Where('id','=',$id)->value('norma_id');
    return $norma_id;
  
  }


  public static function deletefiles($table,$property,$argument,$file,$disk)
  {
      $delete = $table::Where($property,'=',$argument)->value($file);
      Storage::disk($disk)->delete($delete);
       
  }

  public static function timeout()
  {

  }	

  public static function today()
  {
        $mytime = Carbon\Carbon::now();
        $Fecha = $mytime->format('Y-m-d');
        return $Fecha;    
  }

  public static function class_name($id)
  {
      $clases = ClaseNorma::lists('nombre','idclase_norma');
      return $clases[$id];
  }

  public static function enterprise_name($ent)
  {   
    $corporations = Empresa::lists('nombre','idempresa');
    $empresas = explode(",", $ent);
    $i = 0;
    $autenticacion = Auth::user()->EmpresasPermiso;
    $arreglo = explode(",",$autenticacion);
    //return var_dump($empresas);
    foreach ($empresas as $empresa)
    {     
      $i += 1;
      if(isset($corporations[$empresa]))
      { 
        if(in_array($empresa, $arreglo))
        {
          echo '<span style= "font-weight:bold; font-size: 110%"  >'.$i.'</span>'.'.'.$corporations[$empresa];
          echo '<br>';
        }  
        elseif(Auth::user()->rol_id==1)
        {
          echo '<span style= "font-weight:bold; font-size: 110%"  >'.$i.'</span>'.'.'.$corporations[$empresa];
          echo '<br>';
        }        
      }
      else {
        echo "unnasigned";
      } 
      
    }
    
  }

  public static function logos()
  {
    $autenticacion = Auth::user()->EmpresasPermiso;
    if(Auth::user()->rol_id==1)
    {
      $empresas = Empresa::All();
      //echo count($empresas);
      //echo ceil(count($empresas)/10);
    } 
    else
    {   
      //echo "entre";
      $arreglo = explode(",",$autenticacion);
      //echo var_dump($arreglo);
      $empresas = Empresa::Wherein('idempresa',$arreglo)->get();


    }    
    
     for($c=0;$c<ceil(count($empresas)/10);$c++)
     {       
       echo   '<div class="col-lg-1 col-md-1 col-xs-2">';
        
        for($r=($c*10);$r<(($c*10)+9);$r++)
        {          
          if($r==count($empresas))
          {
            break;
          }
          else
          {
            echo '<br>';             
            echo '<img src="'.url('logos/'.$empresas[$r]->path).'" class="img-logo">  </img>';
            echo '<br>';
          }          
        }

       echo '</div>' ;
     } 
    
  }

  public static function logo($id)
  {
    $image = Empresa::where('idempresa','=',$id)->value('path');
    return $image;
  }

  public static function user_name($name)
  {
    $usuarios = Usuario::lists('nombre','idusuario');
    return $usuarios[$name];

  }

   public static function corp_name($name)
  {
    $empresas = Empresa::lists('nombre','idempresa');
    return $empresas[$name];

  }

  public static function eval_req($id)
  {
    $requisito = Evaluacion::Where('id','=',$id)->value('id_Requisito');
    return $requisito;
  }

    
  public static function clean_name_doc($string)
  {
    $numeric = substr($string, 0,2);
    $numeric2 = substr($string, 0,1);
    if(is_numeric($numeric))
    {
      return $string = substr($string, 2,strlen($string)); 
    }
    elseif(is_numeric($numeric2))
    {
      return $string = substr($string, 1,strlen($string)); 
    }
    else{
      return $string;
    }  
  }


  public static function tiponorma_nombre($id)
  {
  		$query = Normas::Where('id','=',$id)->value('tipo_norma_id');
  		$name = TipoNorma::where('idtipo_norma','=',$query)->value('nombre');

  		return $name;
  }


  public static function evaluation_date($id)
  {
    $date = Evaluacion::Where('id','=',$id)->value('Fecha');
    return $date;

  }

  public static function frecuencia_evaluacion($fecha1,$fecha2)
  {
    if($fecha1!=null)
    {
      $date = floor(strtotime($fecha1)/(60*60*24));
      $date2 = floor(strtotime($fecha2)/(60*60*24));
      $oper = $date2-$date;
      switch (true)
      {
        case ($oper>0&&$oper<=45):
        echo 'mensual';
        break;
        case ($oper>45&&$oper<=90):
        echo 'trimestral';
        break;
        case ($oper>90&&$oper<=180):
        echo 'semestral';
        break;
        case ($oper>180&&$oper<=400):
        echo 'anual';
        break;
        default:
        echo 'noasign';
      }  
    }  
    else
    {
      return ' ';
    } 
      
  }
  //proceso schlumberger
  public static function make_x($data)
  {
    if($data==1)
    {
      return 'X';
    }
    else
    {
      return "";
    }  
  }

  public static function risk_level($a,$b)
  {
    $oper = ($a*$b);

    if($a==null){
      return ' ';
    }

    switch ($oper) {
      case ($oper>=0 and $oper<=1):       
        echo 'NEGLIGIBLE';
        break;
      case ($oper>=2 and $oper<=4):      
        echo 'ACEPTABLE';
        break;
      case ($oper>=5 and $oper<=9):      
        echo 'UNDESIRABLE';
        break;
      case ($oper>=10 and $oper<=16):      
        echo 'INTOLERABLE';
        break;
      case ($oper>=17 and $oper<=25):      
        echo 'NO OPERABLE';
        break;                        
      default:
        ECHO 'NO IDEA'; 
        break;
    }
  }


  public static function month_name ($date){
        $mons = array(1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiempre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre");
        $fecha = date_parse_from_format("Y-m", $date);
        $mes = $fecha['month'];
        $year = $fecha['year'];
        return $mons[$mes].' de '.$year;
  }
   

  public static function id_generator($table,$id){


    $query = $table::lists($id)->last();      
    
    if($query!=null)
    {
      //echo 'esta es cuando ya hay id';
      return $query+1;  
    } 
    else {
      //echo 'retorno aca';
      return 1;
    } 
  }

  public static function cons_generator($categoria){
    $query =  Documento::where('id_categoria','=',$categoria)->orderBy('id','desc')->first();
    if($query!=null)
    {
      return $query->id_documento+1;  
    } 
    else {
      return 1;
    }
  }   

  public static function excel_load_error_mult_art($text)
  {

    $whats = 0;
    if(is_numeric($text[0])){ 
      for($i = 0 ; $i<strlen($text) ; $i++ )
      {         
          if($text[$i]==','||$text[$i]==' ')
            {              
              $whats = 1;
              break;
            }           
      }
    }  
      return $whats;
  }


  public static function error_transcripter($text)
  {
    if (strpos($text, "Column 'articulo' cannot be null") == true) {
      return $text = "No existe el articulo o no puede ser reconocido";
    }
    else{
      return $text;
    }
  }

  public static function time_dates($datep)
  {
    if($datep != null )
    {
      $now = time(); // or your date as well
      $your_date = strtotime($datep);
      $datediff = $your_date - $now;
      //echo floor($datediff / (60 * 60 * 24)); 
      return floor($datediff / (60 * 60 * 24));  
    }
    else{
      return '10000000000';
    }
    
  } 

}