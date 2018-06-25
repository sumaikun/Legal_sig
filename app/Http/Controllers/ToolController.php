<?php

namespace Sig\Http\Controllers;

use Illuminate\Http\Request;
use Sig\Http\Requests;
use Sig\Models\Tipomatriz;
use Sig\Models\Empresa;
use Sig\Models\Normas;
use Sig\Models\Articulos;
use Sig\Models\Literales;
use Sig\Models\Tiponorma;
use Sig\Models\Autoridad;
use Sig\Models\Year;
use Sig\Models\Categorias;
use Sig\Models\Factores;
use Sig\Models\Requisitos;
use Sig\Models\Evaluacion;
use Sig\Models\Derogacion;
use Sig\Helpers\Permission;
use Sig\Helpers\Validation;
use Sig\Helpers\Externclass;
use Auth;
use DB;

class ToolController extends Controller
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

    public function herramientas()
    {
    	return view('herramientas.interfaz');
    }

    public function normas()
    {

    	$normas = Normas::OrderBy('id_Tipo_norma')->orderBy('numero')->get();
        $tiposnorma = Tiponorma::All();
        $years = Year::All();
        $autoridades= Autoridad::All();
    	return view('herramientas.ajax.normas',compact('normas','tiposnorma','years','autoridades'));
    }

    public function articulos()
    {
        $tiposnorma = Tiponorma::All();
    	$articulos = DB::Select(DB::RAW("select a.id as id, tp.nombre as tp_norma , n.numero as norma, a.numero as articulo, es.nombre as vigencia, n.id as normaid, em.year as emision, au.nombre as autoridad from Articulos as a INNER JOIN Normas as n on a.id_Normas = n.id INNER JOIN Tipo_norma as tp on n.id_Tipo_norma = tp.id INNER JOIN Estados_vigencia as es on a.id_Estados_vigencia = es.id INNER JOIN Emision as em on n.id_Emision = em.id  INNER JOIN Autoridad_emisora as au on au.id = n.id_Autoridad_emisora where a.deleted_at is null Order by tp.id, n.numero, a.numero "));
    	
    	return view('herramientas.ajax.articulos',compact('articulos','tiposnorma'));
    }

    public function literales()
    {
        $tiposnorma = Tiponorma::Orderby('nombre')->get();

        $articulos = DB::Select(DB::RAW("select a.id as id, tp.nombre as tp_norma , n.numero as norma, a.numero as articulo, es.nombre as vigencia, n.id as normaid, em.year as emision from Articulos as a INNER JOIN Normas as n on a.id_Normas = n.id INNER JOIN Tipo_norma as tp on n.id_Tipo_norma = tp.id INNER JOIN Estados_vigencia as es on a.id_Estados_vigencia = es.id INNER JOIN Emision as em on n.id_Emision = em.id  where a.deleted_at is null Order by tp.id, n.numero "));

    	$literales = DB::Select(DB::RAW("select l.id as id, tp.nombre as tp_norma , n.numero as norma, a.numero as articulo, l.numero as literal, a.id as articuloid, es.nombre as vigencia, em.year as emision from Literales as l INNER JOIN Articulos as a on l.id_Articulos = a.id INNER JOIN Normas as n on a.id_Normas = n.id INNER JOIN Tipo_norma as tp on n.id_Tipo_norma = tp.id INNER JOIN Estados_vigencia as es on l.id_Estados_vigencia = es.id INNER JOIN Emision as em on n.id_Emision = em.id  where l.deleted_at is null Order by tp.id, n.numero "));
    	
        return view('herramientas.ajax.literales',compact('literales','tiposnorma','articulos'));
    }

    public function tpnorma()
    {
    	$tpnormas = Tiponorma::OrderBy('nombre')->get();
    	return view('herramientas.ajax.tp_norma',compact('tpnormas'));	
    }

    public function autoridad()
    {
    	$autoridades = Autoridad::Orderby('nombre')->get();
    	return view('herramientas.ajax.autoridad',compact('autoridades'));	
    }

    public function year()
    {
    	$years = Year::Orderby('year')->get();
    	return view('herramientas.ajax.year',compact('years'));	
    }

    public function factores()
    {
        $tipos = Tipomatriz::lists('nombre','id');
    	$factores = Factores::Orderby('nombre')->get();
    	return view('herramientas.ajax.factores',compact('factores','tipos'));	
    }

    public function categorias()
    {
    	$categorias = Categorias::Orderby('nombre')->get();
    	$tipos = Tipomatriz::lists('nombre','id');
    	return view('herramientas.ajax.categorias',compact('categorias','tipos'));	
    }

    public function actualizar_categoria()
    {
    	$categoria = Categorias::find($_POST['id']);    		
    	$categoria->nombre = $_POST['nombre'];
    	$categoria->id_Factores = $_POST['factor'];
    	
    	$table = new Categorias();
        $property = 'id_Factores';
        $property2 = 'nombre';
        $property3= 'id';
        $argument = $_POST['factor'];
        $argument2 = trim($_POST['nombre']); 
        $argument3 = $_POST['id'];
            

		$validation =  Validation::check_update_twoparams($table,$property,$property2,$property3,$argument,$argument2,$argument3);        
        //return $validation;
        if($validation=='allow')
        {
        	$categoria->save();
        	return 'registro modificado';
        }
    	else{
    		return 'ya existe un registro similar al que intenta guardar';
    	}
    	return $categoria;
    }

    public function nueva_categoria()
    {
    	$table = new Categorias(); 
        $property= 'id_Factores';
        $property2 = 'nombre';
        $argument =  $_POST['factor'];
        $argument2 = trim($_POST['nombre']);

        $validation =  Validation::check_create_twoparams($table,$property,$property2,$argument,$argument2);
        
		if($validation=='allow')
		{
			$categoria = new Categorias; 
		 	$dataset = DB::select(DB::raw("select max(id) as id from Categorias")); 
            $id = 1+$dataset[0]->id;
            $categoria->id = $id;
			$categoria->nombre = trim($_POST['nombre']);
    		$categoria->id_Factores = $_POST['factor'];
    		$categoria->save(); 	
		}

		return $validation;
    }

    public function eliminar_categoria($id)
    {
    	$requisitos = Requisitos::where('id_Categorias','=',$id)->get();
    	$this->eliminar_datos_relacionados($requisitos);
    	$categoria=	Categorias::find($id);
    	$categoria->delete();
        
    	return 'parametro eliminado';
    }

    public function nuevo_factor()
    {
        
        $table = new Factores(); 
        $property= 'id_Tipo_matriz';
        $property2 = 'nombre';
        $argument =  $_POST['tipo'];
        $argument2 = trim($_POST['nombre']);

        $validation =  Validation::check_create_twoparams($table,$property,$property2,$argument,$argument2);
        
        if($validation=='allow')
        {
            $factor = new Factores; 
            $id = Externclass::id_generator($factor,'id');
            $factor->id = $id;
            $factor->nombre = trim($_POST['nombre']);
            $factor->id_Tipo_matriz = $_POST['tipo'];
            $factor->save();     
        }

        return $validation;
    }

    public function eliminar_factor($id)
    {
        $categorias = Categorias::where('id_Factores','=',$id)->get();
        
        foreach($categorias as $categoria)
        {
            $requisitos = Requisitos::where('id_Categorias','=',$categoria->id)->get();
            $this->eliminar_datos_relacionados($requisitos);
            $categoria->delete();
        }     
        
        $factor= Factores::find($id);
        $factor->delete();
        return 'parametro eliminado';
    }

     public function actualizar_factor()
    {        
        $factor = Factores::find($_POST['id']);            
        $factor->nombre = trim($_POST['nombre']);
        $factor->id_Tipo_matriz = $_POST['tipo'];
        
        $table = new Factores();
        $property = 'id_Tipo_matriz';
        $property2 = 'nombre';
        $property3= 'id';
        $argument = $_POST['tipo'];
        $argument2 = trim($_POST['nombre']); 
        $argument3 = $_POST['id'];
            

        $validation =  Validation::check_update_twoparams($table,$property,$property2,$property3,$argument,$argument2,$argument3);        
        
        if($validation=='allow')
        {
            $factor->save();
            return 'registro modificado';
        }
        else{
            return 'ya existe un registro similar al que intenta guardar';
        }
        return $factor;
    }

    public function nuevo_year()
    {
        $table = new Year();
        $argument = $_POST['year'];
        $property =  'year';
        $validation = Validation::check_create_repeat($table , $argument ,$property);
        if($validation == 'allow')
        {   
            $year = new Year;
            $id = Externclass::id_generator($year,'id');
            $year->id = $id;
            $year->year = $_POST['year'];
            $year->save();   
        }
        
        return $validation;        
    }

    public function actualizar_year()
    {
        $table = new Year();
        $property = 'year';
        $idproperty = 'id';

        $validation = Validation::check_update_repeat(trim($_POST['year']),$table,$property,$idproperty,$_POST['id']);      

        if($validation=='allow')
        {      
                
            $year = Year::find($_POST['id']);
            $year->year = $_POST['year'];
            $year->save();
            return "datos actualizados";
        }
        else{
            return "ya hay un año de emisión con esos datos";
        }
    }

    public function eliminar_year($id)
    {
        $normas = Normas::where('id_Emision','=',$id)->get();
        foreach ($normas as $norma) {
            $articulos = Articulos::where('id_Normas','=',$norma->id)->get();
            foreach ($articulos as $articulo) {
                $literales = Literales::where('id_Articulos','=',$articulo->id)->get();
                foreach($literales as $literal)
                {
                    $literal->delete();
                }
                $requisitos = Requisitos::where('id_Articulos','=',$articulo->id)->get();
                $this->eliminar_datos_relacionados($requisitos);
                $articulo->delete();
            }
            $norma->delete();
        }
        $year = Year::find($id);
        $year->delete();
        return "parametro eliminado";
    }

    public function nueva_autoridad()
    {
        $table = new Autoridad();
        $argument = $_POST['nombre'];
        $property =  'nombre';
        $validation = Validation::check_create_repeat($table , $argument ,$property);
        if($validation == 'allow')
        {   
            $autoridad = new Autoridad;
            $dataset = DB::select(DB::raw("select max(id) as id from Autoridad_emisora")); 
            $id = 1+$dataset[0]->id;
            $autoridad->id = $id;
            $autoridad->nombre = $_POST['nombre'];
            $autoridad->save();   
        }
        
        return $validation;
    }

    public function actualizar_autoridad()
    {
        $table = new Autoridad();
        $property = 'nombre';
        $idproperty = 'id';
        $validation = Validation::check_update_repeat(trim($_POST['nombre']),$table,$property,$idproperty,$_POST['id']);      

        if($validation=='allow')
        {      
                
            $autoridad = Autoridad::find($_POST['id']);
            $autoridad->nombre = $_POST['nombre'];
            $autoridad->save();
            return "datos actualizados";
        }
        else{
            return "ya hay una autoridad emisora con esos datos";
        }
    }

    public function eliminar_autoridad($id)
    {
        $normas = Normas::where('id_Autoridad_emisora','=',$id)->get();
        foreach ($normas as $norma) {
            $articulos = Articulos::where('id_Normas','=',$norma->id)->get();
            foreach ($articulos as $articulo) {
                $literales = Literales::where('id_Articulos','=',$articulo->id)->get();
                foreach($literales as $literal)
                {
                    $literal->delete();
                }
                $requisitos = Requisitos::where('id_Articulos','=',$articulo->id)->get();
                $this->eliminar_datos_relacionados($requisitos);
                $articulo->delete();
            }
            $norma->delete();
        }
        $autoridad = Autoridad::find($id);
        $autoridad->delete();
        return "parametro eliminado";
    }

    public function nuevo_tpnorma()
    {
        $table = new Tiponorma();
        $argument = $_POST['nombre'];
        $property =  'nombre';
        $validation = Validation::check_create_repeat($table , $argument ,$property);
        if($validation == 'allow')
        {   
            $tpnorma = new Tiponorma;
            $dataset = DB::select(DB::raw("select max(id) as id from Tipo_norma")); 
            $id = 1+$dataset[0]->id;
            $tpnorma->id = $id;
            $tpnorma->nombre = $_POST['nombre'];
            $tpnorma->save();   
        }
        
        return $validation;
    }

    public function actualizar_tpnorma()
    {
        $table = new Tiponorma();
        $property = 'nombre';
        $idproperty = 'id';
        $validation = Validation::check_update_repeat(trim($_POST['nombre']),$table,$property,$idproperty,$_POST['id']);
              

        if($validation=='allow')
        {              
            $tpnorma = Tiponorma::find($_POST['id']);
            $tpnorma->nombre = $_POST['nombre'];
            $tpnorma->save();
            return "datos actualizados";
        }
        else{
            return "ya hay un Tipo norma con esos datos";
        }
    }

    public function eliminar_tpnorma($id)
    {
        $normas = Normas::where('id_Tipo_norma','=',$id)->get();
        foreach ($normas as $norma) {
            $articulos = Articulos::where('id_Normas','=',$norma->id)->get();
            foreach ($articulos as $articulo) {
                $literales = Literales::where('id_Articulos','=',$articulo->id)->get();
                foreach($literales as $literal)
                {
                    $literal->delete();
                }
                $requisitos = Requisitos::where('id_Articulos','=',$articulo->id)->get();
                $this->eliminar_datos_relacionados($requisitos);
                $articulo->delete();
            }
            $norma->delete();
        }
        $tpnorma = Tiponorma::find($id);
        $tpnorma->delete();
        return "parametro eliminado";    
    }

    public function nuevo_literal()
    {
        $table = new Literales(); 
        $property= 'id_Articulos';
        $property2 = 'numero';
        $argument =  $_POST['articulo'];
        $argument2 = trim($_POST['numero']);

        $validation =  Validation::check_create_twoparams($table,$property,$property2,$argument,$argument2);
        
        if($validation=='allow')
        {
            $literal = new Literales; 
            $dataset = DB::select(DB::raw("select max(id) as id from Literales")); 
            $id = 1+$dataset[0]->id;
            $literal->id = $id;
            $literal->numero = trim($_POST['numero']);
            $literal->id_Articulos = $_POST['articulo'];
            $literal->id_Estados_vigencia = 1;
            $literal->save();     
        }

        return $validation;
    }

    public function actualizar_literal()
    {
        $literal = Literales::find($_POST['id']);            
        $literal->numero = $_POST['numero'];
        $literal->id_Articulos = $_POST['articulo'];
        
        $table = new Literales();
        $property = 'id_Articulos';
        $property2 = 'numero';
        $property3= 'id';
        $argument = $_POST['articulo'];
        $argument2 = trim($_POST['numero']); 
        $argument3 = $_POST['id'];
            

        $validation =  Validation::check_update_twoparams($table,$property,$property2,$property3,$argument,$argument2,$argument3);        
        //return $validation;
        if($validation=='allow')
        {
            $literal->save();
            return 'registro modificado';
        }
        else{
            return 'ya existe un registro similar al que intenta guardar';
        }
    }

    public function eliminar_literal($id)
    {
        $requisitos = Requisitos::where('id_Literales','=',$id)->get();
        $this->eliminar_datos_relacionados($requisitos);
        $literal= Literales::find($id);
        $literal->delete();
        return 'parametro eliminado';
    }

    public function nuevo_articulo()
    {
        $table = new Articulos(); 
        $property= 'id_Normas';
        $property2 = 'numero';
        $argument =  $_POST['norma'];
        $argument2 = trim($_POST['numero']);

        $validation =  Validation::check_create_twoparams($table,$property,$property2,$argument,$argument2);
        
        if($validation=='allow')
        {
            $articulo = new Articulos; 
            $dataset = DB::select(DB::raw("select max(id) as id from Articulos")); 
            $id = 1+$dataset[0]->id;
            $articulo->id = $id;
            $articulo->numero = trim($_POST['numero']);
            $articulo->id_Normas = $_POST['norma'];
            $articulo->id_Estados_vigencia = 1;
            $articulo->save();     
        }

        return $validation;
    }

    public function actualizar_articulo()
    {
        $articulo = Articulos::find($_POST['id']);            
        $articulo->numero = $_POST['numero'];
        $articulo->id_Normas = $_POST['norma'];
        
        $table = new Articulos();
        $property = 'id_Normas';
        $property2 = 'numero';
        $property3= 'id';
        $argument = $_POST['norma'];
        $argument2 = trim($_POST['numero']); 
        $argument3 = $_POST['id'];
            

        $validation =  Validation::check_update_twoparams($table,$property,$property2,$property3,$argument,$argument2,$argument3);        
        //return $validation;
        if($validation=='allow')
        {
            $articulo->save();
            return 'registro modificado';
        }
        else{
            return 'ya existe un registro similar al que intenta guardar';
        }
    }

    public function eliminar_articulo($id)
    {
        $literales = Literales::where('id_Articulos','=',$id)->get();
        foreach ($literales as $literal)
        {
            $literal->delete();       
        }
        $requisitos = Requisitos::where('id_Articulos','=',$id)->get();
        $this->eliminar_datos_relacionados($requisitos);
        $articulo= Articulos::find($id);
        $articulo->delete();
        return 'parametro eliminado';
    }

    public function nueva_norma()
    {
        
        $validation = Normas::Where('id_Tipo_norma',"=",$_POST['tiponorma'])->Where('id_Emision',"=",$_POST['year'])->Where('id_Autoridad_emisora',"=",$_POST['autoridad'])->where('numero','LIKE','%'.trim($_POST['numero']).'%')->count();
        if($validation==0)
        {
          $validation = 'allow';
        }
        else
        { $validation = 'deny';}
        
        if($validation=='allow')
        {
            $norma = new Normas; 
            $dataset = DB::select(DB::raw("select max(id) as id from Normas")); 
            $id = 1+$dataset[0]->id;
            $norma->id = $id;
            $norma->numero = trim($_POST['numero']);
            $norma->id_Tipo_norma = $_POST['tiponorma'];
            $norma->id_Emision = $_POST['year'];
            $norma->id_Autoridad_emisora = $_POST['autoridad'];
            $norma->id_Estados_vigencia = 1; 
            $norma->save();     
        }

        return $validation;
    }

    public function actualizar_norma()
    {
        $norma = Normas::find($_POST['id']);            
        $norma->numero = $_POST['numero'];
        $norma->id_Tipo_norma = $_POST['tiponorma'];
        $norma->id_Emision = $_POST['year'];
        $norma->id_Autoridad_emisora = $_POST['autoridad']; 
        
        $validation = Normas::Where('id_Tipo_norma',"=",$_POST['tiponorma'])->Where('id_Emision',"=",$_POST['year'])->Where('id_Autoridad_emisora',"=",$_POST['autoridad'])->where('numero','LIKE','%'.trim($_POST['numero']).'%')->count();
        $validation2 = Normas::Where('id_Tipo_norma',"=",$_POST['tiponorma'])->Where('id_Emision',"=",$_POST['year'])->Where('id_Autoridad_emisora',"=",$_POST['autoridad'])->where('numero','LIKE','%'.trim($_POST['numero']).'%')->first();

        if($validation==0)
        {
          $validation = 'allow';
        }
        elseif($validation2!=null&&$validation2->id==$_POST['id'])
        {
          $validation = 'allow';
        }  
        else  
        { $validation = 'deny';}        


        if($validation=='allow')
        {
            $norma->save();
            return 'registro modificado';
        }
        else{

            return 'ya existe un registro similar al que intenta guardar';
        }
    }

    public function eliminar_norma($id)
    {
        $articulos = Articulos::where('id_Normas','=',$id)->get();
        
        foreach ($articulos as $articulo)
        {
            $literales = Literales::where('id_Articulos','=',$articulo->id)->get();
            foreach($literales as $literal)
            {
                $literal->delete();
            }
            $requisitos = Requisitos::where('id_Articulos','=',$articulo->id)->get();
            $this->eliminar_datos_relacionados($requisitos);
            $articulo->delete();       
        }

        $norma = Normas::find($id);
        $norma->delete();
        return 'parametro eliminado';
    }

    public function derogar_norma($foid,$id)
    {
        if($foid == $id)
        {
            return 'no se puede derogar por la misma norma';
        }

        /*$table = Derogacion::$table_name;
        $derogacion = new Derogacion;
        $dataset = DB::select(DB::raw("select max(id) as id from ".$table)); 
        $deg_id = 1+$dataset[0]->id;
        $derogacion->id = $deg_id;
        $derogacion->tabla = 'normas';
        $derogacion->id_derogado = $id;
        $derogacion->id_derogante = $foid;
        $derogacion->save();

        $articulos = Articulos::where('id_Normas','=',$id)->get();
                
        foreach ($articulos as $articulo){            
            $articulo->id_Estados_vigencia = 2;
            $articulo->save();
            $literales = Literales::where('id_Articulos','=',$articulo->id)->get();
            foreach ($literales as $literal)
            {
                $literal->id_Estados_vigencia = 2;
                $literal->save();
            }  
        }
        
        $norma = Normas::find($id);
        $norma->id_Estados_vigencia = 2;
        $norma->save();*/
        return "Derogacion exitosa";
    }

    public function derogar_articulo($foid,$id)
    {
        if($foid == $id)
        {
            return 'no se puede derogar con el mismo articulo';
        }

        /*$table = Derogacion::$table_name;
        $derogacion = new Derogacion;
        $dataset = DB::select(DB::raw("select max(id) as id from ".$table)); 
        $deg_id = 1+$dataset[0]->id;
        $derogacion->id = $deg_id;
        $derogacion->tabla = 'articulos';
        $derogacion->id_derogado = $id;
        $derogacion->id_derogante = $foid;
        $derogacion->save();

        $articulo = Articulos::where('id','=',$id)->first();                    
        $articulo->id_Estados_vigencia = 2;
        $articulo->save();             
        $literales = Literales::where('id_Articulos','=',$articulo->id)->get();
        foreach ($literales as $literal)
        {
            $literal->id_Estados_vigencia = 2;
            $literal->save();
        }*/
        return "Derogacion exitosa";        
    }

    public function derogar_literal($foid,$id)
    {
        $table = Derogacion::$table_name;
        $derogacion = new Derogacion;
        $dataset = DB::select(DB::raw("select max(id) as id from ".$table)); 
        $deg_id = 1+$dataset[0]->id;
        $derogacion->id = $deg_id;
        $derogacion->tabla = 'literales';
        $derogacion->id_derogado = $id;
        $derogacion->id_derogante = $foid;
        $derogacion->save();

        $literal = Literales::where('id','=',$id)->first();                    
        $literal->id_Estados_vigencia = 2;
        $literal->save();             

        return "Derogacion exitosa";
    }

    public function derogar_info($id)
    {
        $derogacion = Derogacion::where('id_derogado','=',$id)->where('tabla','=','normas')->first();
        $norma = Normas::where('id','=',$derogacion->id_derogante)->first();
        return $norma->tp_norma->nombre." ".$norma->numero." del año: ".$norma->emision->year." ".$norma->autoridad->nombre;
    }

    public function derogar_info_2($id)
    {
        $derogacion = Derogacion::where('id_derogado','=',$id)->where('tabla','=','articulos')->first();
        if($derogacion !=  null)
        {
            $articulo =  DB::Select(DB::RAW("select  tp.nombre as tp_norma , n.numero as norma, a.numero as articulo, es.nombre as vigencia, n.id as normaid, em.year as emision from Articulos as a INNER JOIN Normas as n on a.id_Normas = n.id INNER JOIN Tipo_norma as tp on n.id_Tipo_norma = tp.id INNER JOIN Estados_vigencia as es on a.id_Estados_vigencia = es.id INNER JOIN Emision as em on n.id_Emision = em.id  where a.id = ".$derogacion->id_derogante));
            $articulo = $articulo[0];
            return $articulo->tp_norma." ".$articulo->norma." del año: ".$articulo->emision." articulo ".$articulo->articulo;
        }
        else{
            $articulo = Articulos::where('id','=',$id)->first();
            $derogacion = Derogacion::where('id_derogado','=',$articulo->id_Normas)->where('tabla','=','normas')->first();
            $norma = Normas::where('id','=',$derogacion->id_derogante)->first();
            return $norma->tp_norma->nombre." ".$norma->numero." del año: ".$norma->emision->year." ".$norma->autoridad->nombre;
                
        }
        
    }

    public function derogar_info_3($id)
    {
      $cond1 = Derogacion::where('id_derogado','=',$id)->where('tabla','=','literales')->first();
      
      $cond2 = Derogacion::where('id_derogado','=',$id)->where('tabla','=','literales')->first();


        if(($cond1 !=  null and !empty($cond1)) or ($cond2 !=  null and !empty($cond2)))
        {
            if($cond1==null)
            {
                $derogacion = $cond1;
            }
            else{ $derogacion = $cond2; }

            $articulo =  DB::Select(DB::RAW("select  tp.nombre as tp_norma , n.numero as norma, a.numero as articulo, es.nombre as vigencia, n.id as normaid, em.year as emision from Articulos as a INNER JOIN Normas as n on a.id_Normas = n.id INNER JOIN Tipo_norma as tp on n.id_Tipo_norma = tp.id INNER JOIN Estados_vigencia as es on a.id_Estados_vigencia = es.id INNER JOIN Emision as em on n.id_Emision = em.id  where a.id = ".$derogacion->id_derogante));
            $articulo = $articulo[0];
            return $articulo->tp_norma." ".$articulo->norma." del año: ".$articulo->emision." articulo ".$articulo->articulo;
        }
        else{

            $articulo = Articulos::where('id','=',$id)->first();      
            $derogacion = Derogacion::where('id_derogado','=',$articulo->id_Normas)->where('tabla','=','normas')->first();            
            $norma = Normas::where('id','=',$derogacion->id_derogante)->first();
            return $norma->tp_norma->nombre." ".$norma->numero." del año: ".$norma->emision->year." ".$norma->autoridad->nombre; 
        }
    }

    public function anular_derogar_norma($id)
    {
        /*$derogacion = Derogacion::where('id_derogado','=',$id)->where('tabla','=','normas')->first();
        $derogacion ->delete();
        $norma = Normas::where('id','=',$id)->first();
        $norma->id_Estados_vigencia = 1;
        $norma->save();
        $articulos = Articulos::where('id_Normas','=',$id)->get();
        foreach ($articulos as $articulo){            
            $articulo->id_Estados_vigencia = 1;
            $articulo->save();  
        }*/
        return 'derogación anulada';

    }

    public function anular_derogar_articulo($id)
    {
        /*$articulo = Articulos::where('id','=',$id)->first();
        $derogacion = Derogacion::where('id_derogado','=',$id)->where('tabla','=','articulos')->first();
        if($derogacion !=  null)
        {
            $derogacion->delete();
        }
        else{            
            $derogacion = Derogacion::where('id_derogado','=',$articulo->id_Normas)->where('tabla','=','normas')->first();
            $derogacion->delete();
        }
        
        $articulo->id_Estados_vigencia = 1;
        $articulo->save();*/
        return 'derogación anulada';        
    }

    public function anular_derogar_literal($id)
    {
        /*$literal = Literales::where('id','=',$id)->first();
        $derogacion = Derogacion::where('id_derogado','=',$id)->where('tabla','=','literales')->first();
        if($derogacion !=  null)
        {
            $derogacion->delete();
        }
        else{            
            $derogacion = Derogacion::where('id_derogado','=',$literal->id_Articulos)->where('tabla','=','articulos')->first();
            if($derogacion !=  null)
            {
                $derogacion->delete();
            }
            else{
                $norma = Articulos::where('id','=',$literal->id_Articulos)->value('id_Normas');
                $derogacion = Derogacion::where('id_derogado','=',$norma)->where('tabla','=','normas')->first();            
                $derogacion->delete();
            }
        }        
        $literal->id_Estados_vigencia = 1;
        $literal->save();*/
        return 'derogación anulada';           
    }

    private function eliminar_datos_relacionados($requisitos)
    {
        foreach ($requisitos as $requisito)
        {
            $evaluacion = Evaluacion::where('id_Requisitos','=',$requisito->id)->first();
            if($evaluacion!=null)
            {
                $evaluacion->delete();
            }
            $requisito->delete();
        }
    }

    public function pass_autoridad($id,$foid)
    {
       if($id == $foid)
       {
         return 'no se puede reemplazar la autoridad emisora con la misma';
       }

       $normas = Normas::where('id_Autoridad_emisora','=',$id)->get();

       foreach($normas as $norma)
       {
            $norma->id_Autoridad_emisora = $foid;
            $norma->save();
       }
       
       $autoridad = Autoridad::where('id','=',$id)->first();

        DB::delete("delete from Autoridad_emisora where id = ".$id);

       return 'Autoridad eliminada'; 

    }

    public function pass_factor($id,$foid)
    {
       if($id == $foid)
       {
         return 'no se puede reemplazar el factor con el mismo';
       }

       $categorias = Categorias::where('id_Factores','=',$id)->get();

       foreach($categorias as $categoria)
       {
            $categoria->id_Factores = $foid;
            $categoria->save();
       }
       
       $factor = Factores::where('id','=',$id)->first();

        DB::delete("delete from Factores where id = ".$id);

       return 'Factor eliminado'; 

    }

    public function pass_categoria($id,$foid)
    {
       if($id == $foid)
       {
         return 'no se puede reemplazar la categoria con la misma';
       }

       $requisitos = Requisitos::where('id_Categorias','=',$id)->get();

       foreach($requisitos as $requisito)
       {
            $requisito->id_Categorias = $foid;
            $requisito->save();
       }
       
       $categoria = Categorias::where('id','=',$id)->first();

        DB::delete("delete from Categorias where id = ".$id);

       return 'Factor eliminado'; 

    }

    public function replace_norma($foid,$id)
    {
        if($foid == $id)
        {
            return 'no se puede eliminar con la misma';
        }
        $articulos = Articulos::where('id_Normas','=',$id)->get();
        foreach($articulos as $articulo)
        {
            $articulo->id_Normas = $foid;
            $articulo->save();
        }
        $derogados = Derogacion::where('id_derogado','=',$id)->where('tabla','=','normas')->get();
        
        foreach($derogados as $derogado)
        {
            if($derogado != null)
            {
                $derogado->id_derogado = $foid;
                $derogado->save();
            }    
        }
        
        $derogados = Derogacion::where('id_derogante','=',$id)->where('tabla','=','normas')->get();

        foreach($derogados as $derogado)
        {
            if($derogado != null)
            {
                $derogado->id_derogante = $foid;
                $derogado->save();
            }    
        }
        

         DB::delete("delete from Normas where id = ".$id);
        return 'norma eliminada';

    }


    public function replace_articulo($foid,$id)
    {
        
        if($foid == $id)
        {
            return 'no se puede eliminar con el mismo articulo';
        }
        $requisitos = Requisitos::where('id_Articulos','=',$id)->get();

        $derogados = Derogacion::where('id_derogado','=',$id)->where('tabla','=','articulos')->get();

        $derogantes = Derogacion::where('id_derogante','=',$id)->where('tabla','=','articulos')->get();            
        
        $literales = Literales::where('id_Articulos','=',$id)->get();

        foreach($literales as $literal)
        {
            $literal->id_Articulos = $foid;
            $literal->save();
        }

        foreach($derogados as $derogado)
        {
            $derogado->id_derogado = $foid;
            $derogado->save();
        }

        foreach($derogantes as $derogado)
        {
            $derogado->id_derogante = $foid;
            $derogado->save();
        }

        foreach($requisitos as $requisito)
        {           
            $requisito->id_Articulos = $foid;
            $requisito->save();
        }
         DB::delete("delete from Articulos where id = ".$id);
        return 'Articulo eliminado';

    }

    public function pass_tpnorma($foid,$id)
    {
        if($id == $foid)
       {
         return 'no se puede reemplazar el tipo norma con el mismo';
       }

       $normas = Normas::where('id_Tipo_norma','=',$id)->get();

       foreach($normas as $norma)
       {
            $norma->id_Tipo_norma = $foid;
            $norma->save();
       }     

        DB::delete("delete from Tipo_norma where id = ".$id);

       return 'Tipo norma eliminada';
    }
}
