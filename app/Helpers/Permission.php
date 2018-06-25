<?php	
namespace Sig\Helpers;
//use App\Providers\AppServiceProvider;
use App;
use Sig\MigracionMatriz;
use Sig\RequisitosMatriz;
use Sig\Evaluacion;
use Sig\Historicom;
use Sig\ClaseNorma;
use Sig\Empresa;
use Sig\Usuario;
use Sig\RelacionHis;
use DB;
use Carbon;
use Auth;
class Permission {

	function __construc(){}

  public static function permission_array()
  {
     $string = Auth::user()->EmpresasPermiso;
     $array = explode(",", $string);
     return $array;

  }



}