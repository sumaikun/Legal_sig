<?php

namespace Sig\Http\Controllers;

use Illuminate\Http\Request;

use Cache;

use Sig\Models\Empresa;

use Sig\Helpers\Permission;

use Symfony\Component\HttpFoundation\Response;

use Illuminate\Contracts\Routing\ResponseFactory;

use Sig\Http\Requests;

use Sig\Models\Factores;

use Sig\Models\Categorias;

use Sig\Models\Normas;

use Sig\Models\Articulos;

use Sig\Models\Autoridad;

use Sig\Models\Year;

use Sig\Models\Literales;

use Auth;

use DB;

class FilterController extends Controller
{

       public function __construct()
    {
        $this->middleware('auth');
    }  
    

    public function filter_factores($tipo_matriz)
    {       
        $factores = Factores::where('id_Tipo_matriz','=',$tipo_matriz)->orderBy('nombre')->get();
        return $factores; 
    }

    public function filter_categorias($factor)
    {       
        $categorias = Categorias::where('id_Factores','=',$factor)->orderBy('nombre')->get();
        return $categorias; 
    }

    public function filter_normas($tipo_norma)
    {       
        //$normas = Normas::where('id_Tipo_norma','=',$tipo_norma)->orderBy('ABS(numero)')->get();
        $normas = DB::Select(DB::RAW("SELECT * FROM Normas where  id_Tipo_norma = '$tipo_norma' order BY ABS(numero)"));
        return $normas; 
    }

    public function filter_articulos($norma)
    {       
        //$articulos = Articulos::where('id_Normas','=',$norma)->orderBy('ABS(numero)')->get();
        $articulos = DB::Select(DB::RAW("SELECT * FROM Articulos where id_Normas = $norma order BY ABS(numero)"));
        return $articulos; 
    }

    public function filter_autoridad($id)
    {
        $norma = Normas::where('id','=',$id)->first();
        $autoridad = Autoridad::where('id','=',$norma->id_Autoridad_emisora)->get();
        return $autoridad;
    }

    public function filter_year($id)
    {
        $norma = Normas::where('id','=',$id)->first();
        $year = Year::where('id','=',$norma->id_Emision)->get();
        return $year;
    }

    public function filter_literal($articulo)
    {
        $literales = Literales::where('id_Articulos','=',$articulo)->get();
        return $literales;
    }    

    public function filter_factores_emp($tipo_matriz,$empresa)
    {
        $factores = DB::Select(DB::RAW("select distinct f.id as id, f.nombre as nombre from Requisitos as r INNER JOIN Categorias as c on r.id_Categorias = c.id INNER JOIN Factores as f on c.id_Factores = f.id where r.id_empresa = ".$empresa." and f.id_Tipo_matriz = ".$tipo_matriz." and f.deleted_at is null order by f.nombre"));
        return $factores; 
    }

    public function filter_categorias_emp($factor,$empresa)
    {       
        $categorias = DB::Select(DB::RAW("select distinct c.id as id, c.nombre as nombre from Requisitos as r INNER JOIN Categorias as c on r.id_Categorias = c.id INNER JOIN Factores as f on c.id_Factores = f.id where r.id_empresa = ".$empresa." and f.id = ".$factor." and c.deleted_at is null order by c.nombre")); 
        return $categorias; 
    }

    public function filter_tpnorma_emp($empresa)
    {
        $tp_normas = DB::Select(DB::raw("select DISTINCT tp.id, tp.nombre from  Requisitos as r inner join Articulos as a on r.id_Articulos = a.id inner join Normas as n on n.id = a.id_Normas INNER JOIN Tipo_norma as tp on tp.id=n.id_Tipo_norma where r.id_empresa = ".$empresa." and tp.deleted_at is null order by tp.nombre"));
        return $tp_normas;
    }

    public function filter_autoridad_emp($empresa)
    {
        $autoridades = DB::Select(DB::raw("select DISTINCT ae.id, ae.nombre from  Requisitos as r inner join Articulos as a on r.id_Articulos = a.id inner join Normas as n on n.id = a.id_Normas INNER JOIN Autoridad_emisora as ae on ae.id=n.id_Autoridad_emisora where r.id_empresa = ".$empresa." and ae.deleted_at is null order by ae.nombre"));
        return $autoridades;
    }

    public function filter_normas_emp($tp_norma,$empresa)
    {       
        $normas = DB::Select(DB::RAW("select DISTINCT n.id, n.numero, CAST(n.numero as SIGNED) as bin from  Requisitos as r inner join Articulos as a on r.id_Articulos = a.id inner join Normas as n on n.id = a.id_Normas where r.id_empresa = ".$empresa." and n.id_Tipo_norma = ".$tp_norma." and n.deleted_at is null order by bin ASC, numero ASC"));
        return $normas; 
    }

    public function filter_articulos_emp($norma,$empresa)
    {       
        $articulos = DB::Select(DB::RAW("select DISTINCT a.id, a.numero, CAST(a.numero as SIGNED) as bin from  Requisitos as r inner join Articulos as a on r.id_Articulos = a.id inner join Normas as n on n.id = a.id_Normas where r.id_empresa = ".$empresa." and a.id_Normas = ".$norma)." and a.deleted_at is null order by bin ASC, numero ASC");
        return $articulos; 
    }

    public function get_emision_and_autority(Request $request)
    {
        $query = DB::Select(DB::RAW("select * from Normas as n inner join Autoridad_emisora as au on au.id = n.id_Autoridad_emisora inner join Emision as e on n.id_Emision = e.id where n.id = ".$request->norma));
        return $query;
    }
}
