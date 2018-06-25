<?php	
namespace Sig\Helpers;
use Exception;

class Exception_manager {

	function __construc(){}

	public static function arrayExcept($array,$index){
			
		try {
	    	 if(isset($array[$index]))
	    	 {
	    	 	return $array[$index];
	    	 }
	    	 else{

	    	 	throw new Exception();
	    	 }

		} catch (Exception $e) {
	      echo "";
		}
	}
   


}