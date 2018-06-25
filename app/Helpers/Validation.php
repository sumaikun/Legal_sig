<?php	
namespace Sig\Helpers;

use Sig\Historicom;
use Sig\RequisitosMatriz;
use Sig\MigracionMatriz;
use Sig\Evaluacion;
use Cache;

class Validation {

	function __construc(){}

   public static function check_update_repeat($argument,$table,$property,$idproperty,$idargument)
  {
  
    $validation = $table::Where($property,"LIKE",'%'.$argument.'%')->count();     
  	$validation2 =$table::Where($idproperty,"=",$idargument)->value($property);
  	$matching = strtoupper($argument);
  	$matching2 = strtoupper($validation2);
  	similar_text($matching,$matching2,$percent);
    //return $percent;

        if($property=='year')
        {
          
          if($validation==1 && $validation2 !=$argument) {
          return 'deny';
           }
        }
        if($validation==0)
        {
          return 'allow';
        } 
  	    if($validation==1 && $percent >= 75) {
        	return 'allow';
        }
        elseif($validation<1){
        	return 'allow';
        }
        elseif($argument==$validation2){
          return 'allow';
        }
        elseif($validation==1 && $argument != $validation2) {
        	return 'deny';
        }
        elseif($validation>1){
        	return 'deny';
        }             

  

  }

  public static function check_create_repeat($table , $argument ,$property)
  {
  	$validation = $table::Where($property,"LIKE",'%'.$argument.'%')->count();

  	if($validation==0)
  	{
  		return 'allow';
  	}
  	else
  	{ return 'deny';}

  }

  public static function check_create_twoparams($table,$property,$property2,$argument,$argument2)
  {
    $validation = $table::Where($property,"=",$argument)->Where($property2,"=",$argument2)->count();

      if($validation==0)
    {
      return 'allow';
    }
    else
    { return 'deny';}

  }

  public static function check_update_twoparams($table,$property,$property2,$property3,$argument,$argument2,$argument3)
  {
    //property 3 y argument 3 hacen referencia al id
    $validation = $table::Where($property,"=",$argument)->Where($property2,"=",$argument2)->count();
    $validation2 = $table::Where($property3,"=",$argument3)->value($property);
    $validation3 = $table::Where($property3,"=",$argument3)->value($property2);

      if($validation==1&&$argument==$validation2&&$argument2==$validation3) 
    {
      return 'allow';
    }
    elseif($validation<1)
     { return 'allow';}
    elseif($validation==1&&$argument!=$validation2&&$argument2!=$validation3)
    {
     return 'deny';
    }
    elseif($validation==1&&$argument==$validation2&&$argument2!=$validation3)
    {
     return 'deny';
    }
    elseif($validation>1)
    {
      return 'deny';
    }  

  }

  public static function check_create_threeparams($table,$property,$property2,$property3,$argument,$argument2,$argument3)
  {

    $validation = $table::Where($property,"=",$argument)->Where($property2,"=",$argument2)->Where($property3,"=",$argument3)->count();
    if($validation==0)
    {
      return 'allow';
    }
    else
    { return 'deny';}


  }

    public static function check_update_threeparams($table,$property,$property2,$property3,$argument,$argument2,$argument3,$type,$typearg,$id)
  {

    $validation = $table::Where($property,"=",$argument)->Where($property2,"=",$argument2)->Where($property3,"=",$argument3)->Where($type,'=',$typearg)->count();
    $validation2 = $table::Where($property,"=",$argument)->Where($property2,"=",$argument2)->Where($property3,"=",$argument3)->Where($type,'=',$typearg)->first();
    if($validation==0)
    {
      return 'allow';
    }
    elseif($validation2!=null&&$validation2->id==$id)
    {
      return 'allow';
    }  
    else  
    { return 'deny';}


  }



  public static function timing($id,$property)
  {
    Cache::put($id,$property, 30);
  }   

    
  public static  function escapeJavaScriptText($string)
  {
    //return str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', (string)$string), "\0..\37'\\")));
    //$string = trim(preg_replace('/\s\s+/', ' ', $string));
    $string = str_replace(array("\r", "\n"), '', $string);
    $string = str_replace("'",'"',$string);
    return $string;
  }


  

}