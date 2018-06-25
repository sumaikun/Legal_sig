<?php

namespace Sig\Http\Controllers;

use Illuminate\Http\Request;

use Sig\Http\Requests;

use Sig\Empresa;

use Sig\Temas;

use Sig\Subfactor;

use Sig\CategoriaAmbiental;

use Sig\Articulos;

use Sig\Normas;

use Sig\Helpers\Externclass;

use Sig\Helpers\Validation;

use Sig\RequisitosMatriz;

use Sig\Requisitos;

use Sig\RequisitosUnsaved;

use Sig\Helpers\Permission;

use Auth;

use DB;

use Sig\Cumplimiento;

use Sig\FactorRiesgo;

use Sig\Year;

use Sig\Autoridad;

use Sig\TipoNorma;

use Sig\Factoresaspecto;

use Sig\AspectoAmbiental;

use Sig\Categoriafa;

use Sig\Evaluacion;

use Sig\MigracionMatriz;

use Sig\Historicom;

use Sig\Helpers\ControladorHistoricos;

use Storage;

use Excel;

use Cache;

class ManagementController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('consult',['only'=>['create','edit','store','update']]);
        if(Auth::user()!=null) 
        {  
         $this->usuario = Auth::user()->idusuario;
        } 
        else
        {
            return  redirect()->guest('/');
        } 
    }


    public function index()
    {    	
    	if(Auth::user()->rol_id!=1)
        {
           
            $array = Permission::Permission_array();
            $empresas=Empresa::Wherein('idempresa',$array)->lists('nombre','idempresa'); 
        }   
        else
        {     
            $empresas=Empresa::lists('nombre','idempresa');
        }
       
               

        $aspectos =  FactorRiesgo::orderBy('nombre','asc')->lists('nombre','idfactor_riesgo');

        $temas = Temas::lists('tema','idtema');
        $tipon = Tiponorma::orderBy('nombre','asc')->lists('nombre','idtipo_norma');
        $years = Year::orderBy('year','asc')->lists('year','id');
        $autoridad = Autoridad::orderBy('nombre','asc')->lists('nombre','id');         

    	return view('MatrizV2.matriz',compact('empresas','aspectos','temas','tipon','years','autoridad'));
    }

    public function filter_enterprise($enterprise)
    {    	
    	$ambiental = 0;

    	$cond = "empresa.idempresa = ".$enterprise." and r.ambiental = ".$ambiental." ";

        $main_query = Externclass::generate_matriz_v2($cond);

        $requisitos = DB::select(DB::raw($main_query));
 
    	return view('MatrizV2.Ajax.list',compact('requisitos'));
    }


    public function other_filters($empresa,$factor,$categoria,$tipon,$norma,$año,$articulo,$estado,$autoridad,$fechasubida)
    {
    	//norma null
    	//return 'ok';
    	$ambiental = 0;

    	$cond = "empresa.idempresa = ".$empresa." and r.ambiental = ".$ambiental." ";

    	if($factor!="placeholder" && $factor!="null")
    	{
    		$cond = $cond."and f.idfactor_riesgo = ".$factor." ";
    	}	
    	if($categoria!="placeholder" && $categoria!="null")
    	{
    		$cond = $cond."and s.idsub_factor_riesgo = ".$categoria." ";
    	}
    	if($tipon!="placeholder" && $tipon!="null")
    	{
    		$cond = $cond."and tp.idtipo_norma = ".$tipon." ";
    	}
    	if($norma!="placeholder" && $norma!="null")
    	{
    		$cond = $cond."and n.id = ".$norma." ";
    	}
    	if($año!="placeholder" && $año!="null")
    	{
    		$cond = $cond."and y.id = ".$año." ";
    	}
    	if($articulo!="placeholder" && $articulo!="null")
    	{
    		$cond = $cond."and a.id = ".$articulo." ";
    	}
    	if($estado!="placeholder" && $estado!="null")
    	{
    		$cond = $cond."and a.Estado_del_Articulo = '".$estado."' ";
    	}
    	if($autoridad!="placeholder" && $autoridad!="null")
    	{
    		$cond = $cond."and au.id = ".$autoridad." ";
    	}
        if($fechasubida!="placeholder" && $fechasubida!="null")
        {
            $cond = $cond."and r.created_at LIKE '%".$fechasubida."%' ";
        }

    	$main_query = Externclass::generate_matriz_v2($cond);

        $requisitos = DB::select(DB::raw($main_query));    	 
    	return view('MatrizV2.Ajax.list',compact('requisitos'));	  
       
    }

    public function data_to_fix(){

        $requisitos  = RequisitosUnsaved::All();
        if(Auth::user()->rol_id!=1)
        {
           
            $array = Permission::Permission_array();
            $empresas=Empresa::Wherein('idempresa',$array)->lists('nombre','idempresa'); 
        }   
        else
        {     
            $empresas=Empresa::lists('nombre','idempresa');
        }
        return view('MatrizV2.tofix',compact('requisitos','empresas')); 

    }


    public function filter_enterprise2($enterprise)
    {       
        $requisitos  = RequisitosUnsaved::Where('empresa','LIKE','%'.$enterprise.'%')->get();
        //return $requisitos; 
        return view('MatrizV2.Ajax.list2',compact('requisitos'));
    }

    public function exchangeultradata(){
    	//time to hack papus
    	
    	$requisitosv1 = RequisitosMatriz::All();
    	
    	foreach ($requisitosv1 as $requisitov1) {

    		$requisitov2 = new Requisitos;
    	 	$requisitov2->id = Externclass::id_generator($requisitov2,'id');
    	 	$grupo = Temas::where('tema','=',$requisitov1->Grupo)->value('idtema');
    	 	$requisitov2->grupo = $grupo;
    	 	if($requisitov1->Ambiental==0)
    	 	{
    	 		$tipo="siso";
    	 		$categoria = Subfactor::where('nombre','=',$requisitov1->CategoriaRiesgo)->value('idsub_factor_riesgo');
    	 	}
    	 	else{
    	 		$tipo="ambiental";
    	 		$categoria = Categoriaambiental::Where('nombre','=',$requisitov1->CategoriaRiesgo)->value('id');	
    	 	}
    	 	$requisitov2->categoria = $categoria;
    	 	$normaid = Normas::where('numero_norma','=',$requisitov1->Numero)->value('id');
    	 	$articuloid = Articulos::where('norma_id','=',$normaid)->where('numero_articulo','=',$requisitov1->ArticuloAplica)->value('id');
    	 	$requisitov2->articulo = $articuloid;
    	 	$requisitov2->ambiental = $requisitov1->Ambiental;
    	 	$requisitov2->empresa = $requisitov1->empresa;
    	 	//CONDICION SI YA HICE EL PROCESO
    	 	$query_cond = Requisitos::where('articulo','=',$articuloid)->first();
    	 	if($query_cond==null)
    	 	{
    	 		try{ 
    	 			$requisitov2->save();
    	 		}
    	 		catch(\Exception  $e)
    	 		{
    	 			if($articuloid == null)
    	 			{
    	 				$description = "Existe un inconveniente con el valor asignado al articulo de este requisito";
    	 			}
    	 			else{

    	 				$description = "existe un inconveniente para guardar este requisito";
    	 			}	

       				$requisitou = new RequisitosUnsaved;
    	 			$requisitou->id = Externclass::id_generator($requisitou,'id');
    	 			$requisitou->factor = $requisitov1->FactorRiesgo;
    	 			$requisitou->categoria = $requisitov1->CategoriaRiesgo;
    	 			$requisitou->grupo = $requisitov1->Grupo;
    	 			$requisitou->tipo_norma = $requisitov1->TipoNorma;
					$requisitou->norma = $requisitov1->Numero;
					$requisitou->articulo = $requisitov1->ArticuloAplica;
					$requisitou->tipo = $tipo;
					$requisitou->description = $e;
                    $requisitou->empresa = $requisitov1->empresa;
                    $requisitou->normasrelacionadas = $requisitov1->NormasRelacionadas;
                    $requisitou->descnorma = $requisitov1->Descnorma;
                    $requisitou->litnum = $requisitov1->LitNum;

					$query_cond = RequisitosUnsaved::where('articulo','=',$requisitou->articulo)->where('norma','=',$requisitou->norma)->where('tipo_norma','=',$requisitou->tipo_norma)->first();
					if($query_cond==null){
						$requisitou->save();
					}       				   
    			}	
    	 	}   	 	
    	 	
    	}
    
    	$requisitosv2 = Requisitos::All();
        return 'terminé';
    }

    public function exchangefactores(){
        $factores = FactorRiesgo::All();
        foreach($factores as $factor){
            $factoras = new Factoresaspecto;
            $factoras->id = Externclass::id_generator($factoras,'id');
            $factoras->code = $factor->idfactor_riesgo;
            $factoras->nombre = $factor->nombre;
            $factoras->ambiental = 0;
            $cond= Factoresaspecto::where('code','=',$factoras->code)->where('ambiental','=',0)->first();
            if($cond==null)
            {
                $factoras->save();
            }
            
        }
        $aspectos = AspectoAmbiental::All();

        foreach($aspectos as $aspecto){            
            $factoras = new Factoresaspecto;
            $factoras->id = Externclass::id_generator($factoras,'id');
            $factoras->code = $aspecto->id;
            $factoras->nombre = $aspecto->nombre;
            $factoras->ambiental = 1;            
            $cond= Factoresaspecto::where('code','=',$factoras->code)->where('ambiental','=',1)->first();
            if($cond==null)
            {
                $factoras->save();
            }

        }

        return 'terminé';

    }

    public function exchangecategorias(){
        $categorias = Subfactor::All();
        foreach($categorias as $categoria){
            $categorian = new Categoriafa;
            $categorian->id = Externclass::id_generator($categorian,'id');
            $categorian->nombre = $categoria->nombre;
            $id_ = Factoresaspecto::where('code','=',$categoria->factor_riesgo_id)->where('ambiental','=',0)->value('id'); 
            $categorian->aspectosfactor_id = $id_;            
            $cond= Categoriafa::where('nombre','=',$categorian->nombre)->where('aspectosfactor_id','=',$categorian->aspectosfactor_id)->first();
            if($cond==null)
            {
                $categorian->save();
            }
            
        }
        $categorias = CategoriaAmbiental::All();

        foreach($categorias as $categoria){            
            $categorian = new Categoriafa;
            $categorian->id = Externclass::id_generator($categorian,'id');
            $categorian->nombre = $categoria->nombre;
            $id_ = Factoresaspecto::where('code','=',$categoria->aspecto_ambiental_id)->where('ambiental','=',1)->value('id'); 
            $categorian->aspectosfactor_id = $id_;            
            $cond= Categoriafa::where('nombre','=',$categorian->nombre)->where('aspectosfactor_id','=',$categorian->aspectosfactor_id)->first();
            if($cond==null)
            {
                $categorian->save();
            }
            
        }

        return 'terminé';

    }


    //Fixing

    public function semantica_na($string){
        $string = strtoupper($string);
        //echo $string;
        $aprox = similar_text($string,"NA",$percent);
        
        if($percent>60){
            return True;
        }
        else{
            return False;
        }
    }

    public function semantica_todo($string){
        $string = strtoupper($string);
        //echo $string;
        $aprox = similar_text($string,"TODO",$percent);
        
        if($percent>70){
            return True;
        }
        else{
            return False;
        }
    }

    public function validation_fixing_data($id){

        $fixes = array();

        $requisito= RequisitosUnsaved::where('id','=',$id)->first();
        
        $requisito->factor = trim($requisito->factor);

        if($this->semantica_na($requisito->factor)==False)
        {
            $validate_factor = Factoresaspecto::where('nombre','LIKE','%'.$requisito->factor.'%')->first();
        
            if($validate_factor==null){
                $fix = ["factor" => True];
            }
            else{
                $fix = ["factor" => False];
            }    
        }
        else{
            $fix = ["factor" => "NA"];
        }    
        

        $fixes = array_merge($fixes, $fix);

        $requisito->categoria = trim($requisito->categoria);
        
        if($this->semantica_na($requisito->categoria)==False)
        {
            $validate_categoria = Categoriafa::where('nombre','LIKE','%'.$requisito->categoria.'%')->where('aspectosfactor_id','=',$validate_factor->id)->first();
            
            if($validate_categoria==null){
                $fix = ["categoria" => True];
            }
            else{
                $fix = ["categoria" => False];
            }
        }
        else{
            $fix = ["categoria" => "NA"];
        }    

        $fixes = array_merge($fixes, $fix);

        $requisito->grupo = trim($requisito->grupo);
        
        if($this->semantica_na($requisito->grupo)==False)
        {
            $validate_tema = Temas::where('tema','LIKE','%'.$requisito->grupo.'%')->first();
            
            if($validate_tema==null){
                $fix = ["tema" => True];
            }
            else{
                $fix = ["tema" => False];
            }
        }
        else{
            $fix = ["tema" => "NA"];
        }    

        $fixes = array_merge($fixes, $fix);

        $requisito->norma = trim($requisito->norma);
        $validate_norma = Normas::where('numero_norma','LIKE','%'.$requisito->norma.'%')->first();        
        
        if($this->semantica_na($requisito->norma)==False)
        {
            if($validate_norma==null){
                $fix = ["norma" => True];
            }
            else{
                $fix = ["norma" => False];
            }

            $fixes = array_merge($fixes, $fix);

            $requisito->articulo = trim($requisito->articulo);
            $validate_articulo = Articulos::where('numero_articulo','LIKE','%'.$requisito->articulo.'%')->where('norma_id','=',$validate_norma->id)->first();
            if($this->semantica_na($requisito->articulo)==False&&$fixes['normas']==False)
            {
                if($validate_articulo==null){
                    $fix = ["articulo" => True];
                }
                else{
                    $fix = ["articulo" => False];
                }
            }
            else{
                //echo'encontrado';
                $fix = ["articulo" => "NA"];    
            }

            $fixes = array_merge($fixes, $fix);
            
        }
       else{
            $fix = ["norma" => "NA"];
        }       

        $fixes = array_merge($fixes, $fix);

        return $fixes;
    }


    public function manual_fixing($id){

        $data = $this->validation_fixing_data($id);
        //return $data;
        return view('MatrizV2.ajax.fixingtools',compact('data'));
    }


    //Subida excel

    public function Excel(){        
        $empresas = Empresa::lists('nombre','idempresa');
        return view('MatrizV2.Excel',compact('empresas'));
    }

    public function ExcelUpload(Request $request){
        
        $opcionSubida = $request->element;
          
        $archivo = $request->file('archivo');
        $nombre_original=$archivo->getClientOriginalName();        
        $extension=$archivo->getClientOriginalExtension();
        if($extension!='xls' && $extension!='xlsx')
        {
            return response()->json(['invalido' => 'Archivo invalido']);
        }

        $resource=Storage::disk('archivos')->put($nombre_original,  \File::get($archivo) );
        $ruta  =  storage_path('archivos') ."/". $nombre_original;
        $opcionSubida = $_POST['element'];
        if($opcionSubida==1 or $opcionSubida==2)
        { 
            if($resource)
            {           

                Excel::selectSheetsByIndex(0)->load($ruta, function($hoja)  
                {
                    
                    $hoja->each(function($fila)
                    {
                      
                        $empresa = $_POST['empresas'];
                        $tipoMatriz = $_POST['type'];
                        $fechaprox = $_POST['fecha'];

                        Cache::put('empresa',$empresa,5);
                        Cache::put('tipo',($tipoMatriz-1),5);
                        Cache::put('prox',$fechaprox,5);

                        static $i=1;
                        static $n =1;
                        static $ex = 1;
                        static $ne = 1;

                        if($fila->factorderiesgoaspecto==null and $fila->grupotema == null and $fila->categoriaderiesgo ==null)
                        {
                            return 'dsd';
                        }       
                        
                        //echo $i." ";

                        $null_condition = $this->strategy_someoneisnull($fila);
                        if($null_condition == False)
                        {
                            $na_condition = $this->strategy_someoneisna($fila);
                            if($na_condition == False)
                            {
                                $lit_condition = $this->lit_strategy($fila);
                                if($lit_condition == False)
                                {
                                    $mult_condition = $this->strategy_mult($fila);
                                    if($mult_condition == False)
                                    {
                                        $tot_condition = $this->strategy_someoneistodo($fila);
                                        if($tot_condition == False)
                                        {
                                            $uploaded = $this->new_requisito($fila);
                                            if($uploaded == 'subido'){
                                                cache::put('subidas',$n,1);
                                                $n++;

                                                echo ' registro '.($i+1).' Subido <br>';
                                            }

                                            if($uploaded == 'existe'){
                                                cache::put('existe',$ex,1);
                                                $ex++;

                                                echo ' registro '.($i+1).' repetido <br>';
                                            }

                                            if($uploaded == 'error'){
                                                echo ' registro '.($i+1).' error <br>';
                                            }

                                            if($uploaded == 'noemp'){
                                                echo ' registro '.($i+1).' empresa asignada <br>';
                                                cache::put('noemp',$ne,1);
                                                $ne++;
                                            }                                            
                                        }
                                        else{
                                        echo ' registro '.($i+1).' error <br>';
                                        }
                                        
                                    }
                                    else{
                                    echo ' registro '.($i+1).' error <br>';
                                    }     
                                    
                                }
                                else{
                                echo ' registro '.($i+1).' error <br>';
                                }                                
                            }
                            else{
                                echo ' registro '.($i+1).' error <br>';
                            }
                        }
                        else{
                                echo ' registro '.($i+1).' error <br>';
                        }
                        $i++;
                        cache::put('totalfilas',$i,1);                        
                    });                                                          
                });

                echo 'Hay '.(cache::get('totalfilas')-1).' filas <br>';
                echo 'Subidos '.cache::get('subidas')."  <br>";
                echo 'Repetidos '.cache::get('existe')."  <br>";
                echo 'Asignados a empresa '.cache::get('noemp')."  <br>";
                echo 'con inconsistencias '.((cache::get('totalfilas')-1)-(cache::get('subidas')+cache::get('existe')+cache::get('noemp')));              
            }
        }            
    }

    public function strategy_someoneisnull($line){
          $headers = array ('factorderiesgoaspecto','grupotema','categoriaderiesgo','tipodenorma','autoridadquelaemite','numero','articuloqueaplica','anodeemision');
          foreach ($headers as $key => $value) {
              if($line->$value==null)
              {
                $this->register_unsavedreq($line,'null',$key);
                return True; 
              }
          }
        return False;
    }

    public function strategy_someoneisna($line){
          $headers = array ('factorderiesgoaspecto','grupotema','categoriaderiesgo','tipodenorma','autoridadquelaemite','numero','articuloqueaplica','anodeemision');
          foreach ($headers as $key => $value) {
              if($this->semantica_na($line->$value)==True)
              {
                $this->register_unsavedreq($line,'na',$key);
                return True; 
              }
          }
        return False;   
    }

    public function lit_strategy($line){
          
       if($line->literal!=null)
       {
            $this->register_unsavedreq($line,'lit',false);
            return True; 
       }
          
        return False;   
    }

    public function strategy_mult($line)
    {
        $text = $line->articuloqueaplica;                 
        if(is_numeric($text[0])){ 
          for($i = 0 ; $i<strlen($text) ; $i++ )
          {         
              if($text[$i]==','||$text[$i]==' ')
                {
                  $this->register_unsavedreq($line,'mult',false);                 
                  return True;
                }           
          }
        }  
          return False;
    }

    public function strategy_someoneistodo($line)
    {
        $text = $line->articuloqueaplica;                 
        if($this->semantica_todo($text)==True)
          {
            $this->register_unsavedreq($line,'tot','articulo');
            return True; 
          }      
        return False;   
    }

    public function register_unsavedreq($line,$type,$info_string){
        $requisitou = new RequisitosUnsaved;
        $requisitou->id = Externclass::id_generator($requisitou,'id');
        $requisitou->factor = $line->factorderiesgoaspecto;
        $requisitou->categoria = $line->categoriaderiesgo;
        $requisitou->grupo = $line->grupotema;
        $requisitou->tipo_norma = $line->tipodenorma;
        $requisitou->norma = $line->numero;
        $requisitou->articulo = $line->articuloqueaplica;
        if(Cache::get('tipo')==1)
        {
            $tipo = "ambiental";
        }    
        else{
            $tipo = "siso";
        }
        $requisitou->tipo = $tipo;
        $requisitou->description = $this->descp_writer($type,$info_string);
        $requisitou->empresa = Cache::get('empresa');
        $requisitou->normasrelacionadas = $line->normasrelacionadas;
        $requisitou->descnorma = $line->descnorma;
        $requisitou->litnum = $line->literal;
        $requisitou->reqlegal = $line->requisitolegal;    
        $requisitou->esperada = $line ->evidenciaesperada;
        $requisitou->cargo = $line ->cargocumplimiento;
        $requisitou->area = $line->areadeaplicacion;   
        $requisitou->clase = $this->assign_classn($line);

        if($line->fechaevaluacion != null and $line->calificacion != null )
        {
            $requisitou->fecha = $line->fechaevaluacion;
            $requisitou->calif = $line->calificacion;
            $requisitou->cump = $line->evidenciacumplimiento; 
        }


        $query_cond = RequisitosUnsaved::where('articulo','=',$requisitou->articulo)->where('norma','=',$requisitou->norma)->where('tipo_norma','=',$requisitou->tipo_norma)->first();
        if($query_cond==null){
            $requisitou->save();
        }
    }

    public function descp_writer($type,$string){
        if($type == "null"){
            $string = "El valor del encabezado ".$string." esta vacio o es invalido";
        }
        if($type == "na"){
            $string = "El valor del encabezado ".$string." tiene un valor invalido(N.A no valido)";
        }
        if($type == "lit"){
            $string = "Temporalmente el sistema no podra registrar los literales";
        }
        if($type == "mult"){
            $string = "Los articulos estan en una estructura inentendible para el sistema";
        }
        if($type == "tot"){
            $string = "El valor del encabezado ".$string." tiene un valor invalido(total no valido)";
        }
        if($type == "unkn"){
            $string = "error sql ".$string;
        }

        return $string; 
    }

     
    public function new_requisito($line)
    {
        echo 'entre a crear el req <br>';
        $line->grupotema = trim($line->grupotema);
        $line->tipodenorma = trim($line->tipodenorma);
        $line->categoriaderiesgo = trim($line->categoriaderiesgo);
        $line->factorderiesgoaspecto = trim($line->factorderiesgoaspecto);
        $line->autoridadquelaemite = trim( $line->autoridadquelaemite);
        $line->numero = trim($line->numero);
        $line->articuloqueaplica = trim($line->articuloqueaplica);
        $line->anodeemision = trim($line->anodeemision);

        $empresa = Cache::get('empresa');
        $tp_norma = Tiponorma::where('nombre','=',$line->tipodenorma)->first();
        if($tp_norma==null){
            
            $tp_norma = $this->create_tpnorma($line);
        }
        $autoridad = Autoridad::Where('nombre',"=",$line->autoridadquelaemite)->first();
        if($autoridad==null){
            
            $autoridad = $this->create_autoridad($line);
        }
        $year = Year::Where('year',"=",$line->anodeemision)->first();          
        if($year==null){
            
            $year = $this->create_year($line);
        }
        $normaid = Normas::where('numero_norma','=',$line->numero)->where('tipo_norma_id','=',$tp_norma->idtipo_norma)->value('id');
        if($normaid==null)
        {
            
            $normaid = $this->create_norma($line,$tp_norma,$autoridad,$year);
        }
        else{
            $this->update_norma($normaid,$line);
        }      
        $articuloid = Articulos::where('norma_id','=',$normaid)->where('numero_articulo','=',$line->articuloqueaplica)->value('id');
        if($articuloid==null){
            $articuloid = $this->create_articulo($normaid,$line);
        }
        $query_cond = Requisitos::where('articulo','=',$articuloid)->first();
        if($query_cond==null)
        {
            $requisito = new Requisitos;
            $requisito->id = Externclass::id_generator($requisito,'id');        
            $grupo = Temas::where('tema','=',$line->grupotema)->value('idtema');
            if($grupo==null){
                $grupo = $this->create_grupo($line);
            }
            $requisito->grupo = $grupo;
            $factor = Factoresaspecto::where('nombre','LIKE','%'.$line->factorderiesgoaspecto.'%')->first();
            if($factor==null){
                
                $factor = $this->create_factor($line);
            }
            $categoria = Categoriafa::where('nombre','LIKE','%'.$line->categoriaderiesgo.'%')->where('aspectosfactor_id','=',$factor->id)->value('id');
            
            if($categoria==null){
                
                $foid = $factor->id;
                $categoria = $this->create_categoria($line,$foid);
            }
            $requisito->categoria = $categoria;                                               
            $requisito->articulo = $articuloid;
            if(Cache::get('tipo')==1)
            {
                $tipo = "ambiental";
            }    
            else{
                $tipo = "siso";
            }
            $requisito->ambiental = $tipo;
            $requisito->empresa = $empresa;
            //CONDICION SI YA HICE EL PROCESO
            
                try{
                        $foid = $requisito->id;
                        //echo (String)$requisito.'<br>';                                            
                        $requisito->save();
                        $this->new_cumplimiento($line,$foid);
                        if($line->fechaevaluacion != null and $line->calificacion != null )
                        {
                            $this->new_evaluation($line,$foid);
                        }               
                        $string = 'subido';                    

                }
                catch(\Exception  $e)
                {
                   $this->register_unsavedreq($line,'unkn',$e);
                   $string = 'error'; 
                }    

                return $string;
        }
        else
        {
            $array = explode(',', $query_cond->empresa);
            if(!in_array($empresa, $array))
            {
              //echo 'no existe la empresa en el req<br>';                                              
              $query_cond->empresa = $query_cond->empresa.','.$empresa;   
              $query_cond->save();
              $this->new_cumplimiento($line,$query_cond->id);
              if($line->fechaevaluacion != null and $line->calificacion != null and Cache::get('prox')!= null)
              {
                $this->new_evaluation($line,$query_cond->id);
              }
              return 'noemp';                
            }
            else{
                return 'existe';
            }
            
                        
        }

               

    }

    public function create_grupo($line){
        $new_grupo = new Temas;
        $new_grupo->idtema = Externclass::id_generator($new_grupo,'idtema');
        $new_grupo->tema = $line->grupotema;
        $new_grupo->save();
        return $new_grupo->idtema;
    }
    public function create_factor($line){
        $new_factor = new Factoresaspecto;
        $new_factor->id = Externclass::id_generator($new_factor,'id');
        $new_factor->code = $this->code_generator(Cache::get('tipo'));
        $new_factor->nombre = $line->factorderiesgoaspecto;
        $new_factor->save();
        return $new_factor;
    }


    public function code_generator($type){
        $code = Factoresaspecto::where('ambiental','=',$type)->orderBy('id','desc')->first();
        return ($code->code)+1;
    }

    public function create_categoria($line,$fo_id){
        $new_categoria = new Categoriafa;
        $id = Externclass::id_generator($new_categoria,'id');
        //echo 'id de la categoria'.$id;
        $new_categoria->id = $id;
        $new_categoria->nombre =  $line->categoriaderiesgo;
        $new_categoria->aspectosfactor_id = $fo_id;
        $new_categoria->save();
        //echo 'categoria'.(String)$new_categoria.'<br>';
        return $id;        
    }

    public function create_tpnorma($line){
        $new_tp = new Tiponorma;
        $new_tp->idtipo_norma = Externclass::id_generator($new_tp,'idtipo_norma');
        $new_tp->nombre = $line->tipodenorma;
        $new_tp->save();
        return $new_tp;
    }
    public function create_autoridad($line){
        $new_au = new Autoridad;
        $new_au->id  = Externclass::id_generator($new_au,'id');
        $new_au->nombre = $line->autoridadquelaemite;
        $new_au->save();
        return $new_au;  
    }
    public function create_year($line){
        $new_y = new Year;
        $new_y->id = Externclass::id_generator($new_y,'id');
        $new_y->year = $line->anodeemision;
        $new_y->save();
        return $new_y; 
    }
    public function create_norma($line,$tp_norma,$aut,$year){
        $new_n = new Normas;
        $new_n->id = Externclass::id_generator($new_n,'id');
        $new_n->numero_norma = $line->numero;
        $new_n->tipo_norma_id = $tp_norma->idtipo_norma; 
        $new_n->autoridad_emisora_id = $aut->id;
        $new_n->yearemision_id = $year->id;
        $new_n->descripcion_norma = $line->descnorma;
        $new_n->norma_relacionadas = $line->normasrelacionadas;
        $new_n->save();
        return $new_n->id;
    }

    public function update_norma($id,$line){
        $unorma = Normas::where('id','=',$id)->first();
        $unorma->descripcion_norma = $line->descnorma;
        $unorma->norma_relacionadas = $line->normasrelacionadas;
        $unorma->save();
    }

    public function create_articulo($foid,$line)
    {
        $new_ar = new Articulos;
        $new_ar->id = Externclass::id_generator($new_ar,'id');
        $new_ar->norma_id = $foid;
        $new_ar->numero_articulo = $line->articuloqueaplica;
        $new_ar->literal_numeral = $line->literal;
        $new_ar->save();
        return $new_ar->id;
    }

    public function new_cumplimiento($line,$foid){
        //echo 'entre <br>';
        $query_cond = Cumplimiento::where('empresa','=',Cache::get('empresa'))->where('Req_asociado','=',$foid)->first();       
        if($query_cond==null)
        {
            $new_cump = new Cumplimiento;
            //$new_cump->id = Externclass::id_generator($new_cump,'id');         
            $new_cump->Clase_norma_id = $this->assign_classn($line);
            $new_cump->empresa = Cache::get('empresa');
            $new_cump->Req_asociado = $foid;
            $new_cump->Requisito = $line->requisitolegal;    
            $new_cump->EvidenciaEsperada = $line ->evidenciaesperada;
            $new_cump->Responsable = $line ->cargocumplimiento;
            $new_cump->AreaAplicacion = $line->areadeaplicacion;              
            //echo (String)$new_cump.'<br>';            
            $new_cump->save();                         
               
        }
        
    }

    public function assign_classn($line)
    {
        if($line->obligatoria!=null or $line->derogada!=null)
        {
            return 1;
        }
        else{
            return 2;
        }
    }

    public function new_evaluation($line,$foid)
    {
        $validation = Validation::record_evaluations(Cache::get('prox'),Cache::get('empresa'),$foid,Cache::get('tipo'));
        if($validation=='allow') 
        {

            echo 'entre a eval <br>';        
            $miracle = ControladorHistoricos::exist(Cache::get('prox'),Cache::get('empresa'),$this->usuario,Cache::get('tipo'));
            //echo '<span class="proce">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspDatos registrados</span>';
            
            Evaluacion::create([
                              
                'Fecha' =>$line->fechaevaluacion,            
                'Calificacion' =>$line->calificacion,
                'EvidenciaCumplimiento' =>$line->evidenciacumplimiento,
                'id_Requisito' =>$foid,
                'empresa' =>Cache::get('empresa'),
                'Usuario' =>$this->usuario,
            ]);

             $eval = Evaluacion::where('empresa','=',Cache::get('empresa'))->where('id_Requisito','=',$foid)->value('id'); 
             
             $cumplimiento = Cumplimiento::where('empresa','=',Cache::get('empresa'))->where('Req_asociado','=',$foid)->value('id');

             MigracionMatriz::create([
                    'id_requisito'=>$foid,
                    'id_cumplimiento'=>$cumplimiento,
                    'id_evaluacion'=>$eval,
                    'id_usuario'=>$this->usuario,  
                    'id_historico' =>$miracle,                                 
             ]); 

        }
        else{
            echo 'no entre a eval <br>';
        }                             
    }

   

    public function whats(){
        $enterprise = 14;
        $ambiental = 0;
        $cond = "empresa.idempresa = ".$enterprise." and r.ambiental = ".$ambiental." ";
        $main_query = Externclass::generate_matriz_v2($cond);
        $requisitos = DB::select(DB::raw($main_query));
        $requisitos2 = Requisitos::where('empresa','=',14)->get();
        $array1 = array();
        $count = 0;
        foreach($requisitos as $requisito)
        {
            array_push($array1, $requisito->id);
        }
        foreach ($requisitos2 as $requ) {
            if(!in_array($requ->id, $array1)){
                static $i = 0;
                echo "requisito con id ".$requ->id," no incluido en el sistema de matriz <br>";
                $i++;
                $count = $i;
            }
        }

        echo "total ".$count."<br>";
                
        //return $array1;
    }

    public function deleteinvaliddata(){
        $normas = Normas::All();
        foreach($normas as $norma)
        {
            /*$query = Tiponorma::where('idtipo_norma','=',$norma->tipo_norma_id)->value('nombre');
            if($query == null)
            {
                echo "encontre uno respecto a tiponorma";
                echo '<br>';    
            }

            $query = Year::where('id','=',$norma->yearemision_id)->value('year');
            if($query == null)
            {
                echo "encontre uno respecto a yearemision";
                echo '<br>';    
            }
            else{
                //echo $query;
            }

            $query = Autoridad::where('id','=',$norma->autoridad_emisora_id)->value('nombre');
            if($query == null)
            {
                echo "encontre uno respecto a autoridad emisora";
                echo '<br>';    
            }
            else{
                //echo $query;
            }*/
            $query = Tiponorma::where('idtipo_norma','=',$norma->tipo_norma_id)->value('nombre');          

            $query2 = Year::where('id','=',$norma->yearemision_id)->value('year');
           
            $query3 = Autoridad::where('id','=',$norma->autoridad_emisora_id)->value('nombre');
            
            if($query == null or $query2 == null or $query3 == null)
            {
                echo $norma->id;
                DB::select(Db::raw("Delete from normas where id = ".$norma->id));
            }
           
            
        }

        echo "terminé"; 
    }

    public function deleteinvaliddata2(){
        $articulos =  Articulos::All();
        $array =  array();
        foreach ($articulos as $articulo) {
             $query = Normas::where('id','=',$articulo->norma_id)->value('numero_norma');
             if($query == null)
             {
                $deprecated_r = RequisitosMatriz::where('ArticuloAplica','LIKE',$articulo->numero_articulo)->value('id');
                $erased_evals = Evaluacion::where('id_Requisito','=',$deprecated_r)->get();
                foreach ($erased_evals as $evals)
                {
                   $migracion_old = MigracionMatriz::Where('id_evaluacion','=',$evals->id)->get();
                   foreach ($migracion_old as $mig)
                   {
                        array_push($array, $mig->id);
                   }
                    DB::select(Db::raw("Delete from MigracionMatriz where id_evaluacion = ".$evals->id));  
                }
                $historicomes = Historicom::All();
                foreach($historicomes as $historicom)
                {
                    if(in_array($historicom->id, $array)){
                        DB::select(Db::raw("Delete from HistoricoMigracion where id = ".$historicom->id));
                    }
                }
                if($deprecated_r!=null)
                { 
                    DB::select(Db::raw("Delete from Evaluacion where id_Requisito = ".$deprecated_r));
                    DB::select(Db::raw("Delete from RequisitosMatriz where id = ".$deprecated_r));
                    DB::select(Db::raw("Delete from EstadoCumplimiento where Req_asociado = ".$deprecated_r));
                }
                DB::select(Db::raw("Delete from Articulos where id = ".$articulo->id));
                echo "terminé";
                echo '<br>';  
             }
             
         } 
    }

    public function deleteinvaliddata3(){
        $estados = Cumplimiento::All();
        foreach ($estados as $estado)
        {
            $req = Requisitos::where('id','=',$estado->Req_asociado)->value('id');
            if($req == null)
            {
                 DB::select(Db::raw("Delete from EstadoCumplimiento where id = ".$estado->id));
            }
            
        }
        echo "terminé";
    }

    public function deleteinvaliddata4(){
        $migraciones = MigracionMatriz::All();
        $array = array();
        foreach ($migraciones as $migracion)
        {
            $eval = Evaluacion::where('id','=',$migracion->id_evaluacion)->value('id'); 
            if($eval == null)
            {
                DB::select(Db::raw("Delete from MigracionMatriz where id = ".$migracion->id));
            }

            $req = Requisitos::where('id','=',$migracion->id_requisito)->value('id'); 
            if($req == null)
            {
                DB::select(Db::raw("Delete from MigracionMatriz where id = ".$migracion->id));
            }

            $cump = Cumplimiento::where('id','=',$migracion->id_cumplimiento)->value('id'); 
            if($cump == null)
            {
                DB::select(Db::raw("Delete from MigracionMatriz where id = ".$migracion->id));
            }
            
            
                      
        }
        echo "terminé";
    }

    public function deleteinvaliddata5(){
        $evals = Evaluacion::All();
        $array = array();
        foreach ($evals as $eval)
        {
            $req = Requisitos::where('id','=',$eval->id_Requisito)->value('id'); 
            if($req == null)
            {
                DB::select(Db::raw("Delete from Evaluacion where id = ".$eval->id));
            }
           
                      
        }
        echo "terminé";
    }


}

/*  echo $fila->factorderiesgoaspecto;
    echo $fila->grupotema;
    echo $fila->categoriaderiesgo;   
    echo $fila->tipodenorma;
    echo $fila->autoridadquelaemite;
    echo $fila->numero;
    echo $fila->articuloqueaplica;
    echo $fila->anodeemision;

    echo $fila->normasrelacionadas;
    echo $fila->descnorma;

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



  $consulta = RequisitosMatriz::where('Numero','=',$fila->numero)->where('ArticuloAplica','=',$fila->articuloqueaplica)->Where('TipoNorma','=',$fila->tipodenorma)->where('Ambiental','=',$ambiental)->first();

                        if($consulta!=null)
                        {
                            //echo 'encontrado';
                            //echo $i.' '.$fila->fechaevaluacion.' '.$fila->calificacion.' '.$fila->evidenciacumplimiento;

                            //echo '<br>';
                            $i++;
                            if($fila->fechaevaluacion!=null&&$fila->calificacion!=null)
                            {
                                        
                                $validation = Validation::record_evaluations($fechaprox,$empresa,$consulta->id,$ambiental);             

                                if($validation=='allow') 
                                {     
                                            
                                    $miracle = ControladorHistoricos::exist($fechaprox,$empresa,$this->usuario,$ambiental);

                                    //echo '<span class="proce">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspDatos registrados</span>';
                                    
                                    Evaluacion::create
                                    ([
                                                      
                                        'Fecha' =>$fila->fechaevaluacion,            
                                        'Calificacion' =>$fila->calificacion,
                                        'EvidenciaCumplimiento' =>$fila->evidenciacumplimiento,
                                        'id_Requisito' =>$consulta->id,
                                        'empresa' =>$empresa,
                                        'Usuario' =>$this->usuario,
                                    ]);

                                     $eval = Evaluacion::lists('id')->last(); 
                                     
                                     $cumplimiento = Cumplimiento::where('empresa','=',$empresa)->where('Req_asociado','=',$consulta->id)->value('id');

                                     MigracionMatriz::create([
                                            'id_requisito'=>$consulta->id,
                                            'id_cumplimiento'=>$cumplimiento,
                                            'id_evaluacion'=>$eval,
                                            'id_usuario'=>$this->usuario,  
                                            'id_historico' =>$miracle,
                                                         
                                     ]); 

                                    if(strtoupper(Externclass::corp_name($empresa))=='SCHLUMBERGER')
                                    {
                                        if($fila->Likelihood!=null&&$fila->Severity!=null)
                                        {  
                                            if($fila->barranca!=null){
                                                $Barranca = 1;
                                            }
                                            if($fila->cota!=null){
                                                $Cota = 1;
                                            }
                                            if($fila->guafilia!=null){
                                                $Guafilia = 1;
                                            }
                                            if($fila->villavicencio!=null){
                                                $Villavicencio = 1;
                                            }
                                            if($fila->neiva!=null){
                                                $Neiva = 1;
                                            }
                                            if($fila->oficinas!=null){
                                                $Oficinas = 1;
                                            }

                                            Eval_schlum::create([
                                                'id_evaluacion'=>$eval,
                                                'Barranca'=>$Barranca,
                                                'Cota'=>$Cota,
                                                'Guafilia'=>$Guafilia,
                                                'Villavicencio'=>$Villavicencio,
                                                'Neiva'=>$Neiva,
                                                'Oficinas'=>$Oficinas,
                                                'Probabilidad'=>$fila->Likelihood,
                                                'Severidad'=>$fila->Severity,
                                             ]);
                                        }           
                                            
                                    }
                                }

                                elseif($validation=='repeated')
                                {                                       
                                    $eval =MigracionMatriz::Where('id_requisito','=',$consulta->id)->value('id_evaluacion');
                                    $update = Evaluacion::find($eval);
                                    $update ->fill([
                                             'Fecha' =>$fila->fechaevaluacion,            
                                             'Calificacion' =>$fila->calificacion,
                                             'EvidenciaCumplimiento' =>$fila->evidenciacumplimiento,
                                             'id_Requisito' =>$consulta->id,
                                              'empresa' =>$empresa,
                                              'Usuario' =>$this->usuario,
                                        ]);                                     
                                    
                                    $update->save();




    */