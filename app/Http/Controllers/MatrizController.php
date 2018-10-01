<?php

namespace Sig\Http\Controllers;

use Illuminate\Http\Request;

use Sig\Http\Requests;
use Sig\Http\Controllers\Controller;
use Sig\Models\Categorias;
use Sig\Models\Evaluacion;
use Sig\Models\Comentario;
use Sig\Helpers\Externclass;
use Sig\Helpers\Validation;
use Sig\Helpers\Permission;
use Sig\Models\ClaseNorma;
use Sig\Models\Tiponorma;
use Sig\Models\Tipomatriz;
use Sig\Models\Autoridad;
use Sig\Models\Empresa;
use Sig\Models\Articulos;
use Sig\Models\Normas;
use Sig\Models\Year;
use Sig\Models\Requisitos;
use Sig\Models\RequisitosUnsaved;
use Sig\Models\Literales;
use Sig\Models\Factores;
use Sig\Models\Correo;
use Auth;
use Storage;
use Cache;
use DB;
use Excel;
use PHPExcel_Worksheet_Drawing;
use Carbon;
use Mail;
use Sig\Models\MailPermission;
use Sig\Models\Usuario;

class MatrizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    public function matriz_query($condition){
        $query = "select Fecha = (select MAX(Evaluacion.fecha)  from Evaluacion LEFT JOIN Requisitos on Evaluacion.id_Requisitos = Requisitos.id where Requisitos.id = r.id ) as conditioner, r.id as id, r.nrelacionadas as relacionada ,tm.nombre as Tipo, f.nombre as Factor , c.nombre as Categoria, tp.nombre as Tpnorma , au.nombre as Autoridad , y.`year` as Emision , n.numero as Numero , a.numero as Articulo , es.nombre as Estado, es.id as es_id, l.numero as Literal , n.descripcion as Descnorma , r.nrelacionadas as Nrelacionadas ,r.reqlegal as Reqlegal , r.esperada as Esperada , r.area as Area , r.responsable as Cargo , cl.nombre as Clase , eval.fecha as Fecha , eval.cumplimiento as Cumplimiento , eval.Calificacion as Calif , eval.fecha_prox as Prox from Requisitos as r inner JOIN empresa as e on r.id_empresa = e.idempresa INNER JOIN Categorias as c on c.id = r.id_Categorias INNER JOIN Factores as f on f.id = c.id_Factores INNER JOIN Tipo_matriz as tm on tm.id = f.id_Tipo_matriz INNER JOIN Articulos as a on a.id = r.id_Articulos INNER JOIN Normas as n on n.id = a.id_Normas  INNER JOIN Tipo_norma as tp on tp.id=n.id_Tipo_norma INNER JOIN Autoridad_emisora as au on au.id = n.id_Autoridad_emisora INNER JOIN Emision as y on y.id = n.id_Emision INNER JOIN Clase_norma as cl on cl.id = r.id_Clase_norma INNER JOIN Estados_vigencia as es on es.id = a.id_Estados_vigencia  LEFT JOIN Literales as l on l.id = r.id_Literales LEFT JOIN Evaluacion as eval on eval.id_Requisitos = r.id  where ".$condition." and r.deleted_at is null having conditioner = 1 or conditioner is null ORDER BY id ";

        return $query;
    }
    
    public function excel_upload_interface()
    {
        $empresas = $this->empresas;       
        return view('Matriz.Excel',compact('empresas'));
    }

    public function excel_upload_file(Request $request)
    {
        
        $archivo = $request->file('archivo');
        $nombre_original=$archivo->getClientOriginalName();        
        $extension=$archivo->getClientOriginalExtension();
        if($extension!='xls' && $extension!='xlsx')
        {
            return response()->json(['invalido' => 'Archivo invalido']);
        }

        $resource=Storage::disk('archivos')->put($nombre_original,  \File::get($archivo) );
        $ruta  =  storage_path('archivos') ."/". $nombre_original;

        $empresa = $_POST['empresas'];
        
        Cache::put('empresa',$empresa,5);
        //echo "variable de cache ".Cache::get('empresa');
        if($resource)
        {           
              Excel::selectSheetsByIndex(0)->load($ruta, function($hoja)  
            {
                
                $hoja->each(function($fila)
                {
                    static $i=1;
                    static $n =1;
                    static $ex = 1;             
                    static $ne = 1;
                    static $rer = 1;

                    if($fila->factorderiesgoaspecto==null and $fila->grupotema == null and $fila->categoriaderiesgo ==null)
                    {
                        return 'error formato';
                    }       
                    
                    //echo $i." ";
                    $null_condition = $this->strategy_someoneisnull($fila);
                    $na_condition = $this->strategy_someoneisna($fila);                    
                    $tot_condition = $this->strategy_someoneistodo($fila);
                    $length_condition = $this->strategy_length($fila);

                    if($null_condition == True)
                    {                        
                        $mult_condition = False;    
                    }
                    else{
                        $mult_condition = $this->strategy_mult($fila);
                    }                    
                    if($null_condition== False and $na_condition==False and $tot_condition==False and $mult_condition==False and $length_condition==False)
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

                        if($uploaded == 'error_repetido'){
                            cache::put('repeater',$rer,1);
                            $rer++;
                            echo ' registro '.($i+1).' error repetido<br>';
                        }
                      
                    }
                    else{
                        $text = $this->error_detector($null_condition,$na_condition,$tot_condition,$mult_condition,$length_condition);
                        $mistake = $this->register_unsavedreq($fila,'auto',$text);
                        if($mistake == 'error_repetido'){
                            cache::put('repeater',$rer,1);
                            $rer++;
                            echo ' registro '.($i+1).' error repetido<br>';
                        }
                        else{
                            echo ' registro '.($i+1).' error <br>';
                        }
                                 
                    }                            
                    $i++;
                    cache::put('totalfilas',$i,1);                        
                });                                                          
            });

            echo 'Hay '.(cache::get('totalfilas')-1).' filas <br>';
            echo 'Subidos '.cache::get('subidas')."  <br>";
            echo 'Repetidos '.cache::get('existe')."  <br>";
            echo 'errores repetidos'.cache::get('repeater')."  <br>";                        
            echo 'con inconsistencias '.((cache::get('totalfilas')-1)-(cache::get('subidas')+cache::get('existe'))-cache::get('repeater'));
            
            Cache::forget('totalfilas');
            Cache::forget('subidas');
            Cache::forget('existe');
            Cache::forget('repeater');   
                                   
        }
    }

      public function strategy_someoneisnull($line){
          $headers = array ('factorderiesgoaspecto','grupotema','categoriaderiesgo','tipodenorma','autoridadquelaemite','numero','articuloqueaplica','anodeemision');
          foreach ($headers as $key => $value) {
              if($line->$value==null)
              {                
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
                return True; 
              }
          }
        return False;   
    }


    public function strategy_mult($line)
    {       
        $text = trim($line->articuloqueaplica);                 
        if(is_numeric($text[0])){ 
          for($i = 0 ; $i<strlen($text) ; $i++ )
          {         
              if($text[$i]==','||$text[$i]==' ')
                {
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
            return True; 
          }      
        return False;   
    }

    public function strategy_length($line)
    {
        //echo 'tamaño :'.strlen($line->tipodenorma);
        if(strlen($line->tipodenorma) > 44 or strlen($line->numero)  > 44 or strlen($line->autoridadquelaemite)  > 80 or strlen($line->articuloqueaplica) > 44 or strlen($line->literal) > 44)
        {
            return True;
        }
        return False;
    }

    public function error_detector($null_condition,$na_condition,$tot_condition,$mult_condition,$length_condition)
    {
        $text = " ";
        if($null_condition == True){
            $text = $text." X. Hay valores vacios %null% que impiden el registro del requisito ";
        }
        if($na_condition == True){
            $text = $text." X. Hay valores no validos %na% que impiden el registro del requisito";
        }        
        if($mult_condition == True){
            $text = $text." X. Los articulos estan en una estructura inentendible para el sistema %mult% ";
        }
        if($tot_condition == True){
            $text = $text." X. Hay valores no validos %todo% que impiden el registro del requisito ";
        }
        if($length_condition == True){
            $text = $text." X. Hay valores muy largos no validos %largos% que impiden el registro del requisito ";
        }

        return $text;
    }

    public function register_unsavedreq($line,$type,$info_string){
        $empresa = Cache::get('empresa');
        $requisitou = new RequisitosUnsaved;
        $requisitou->id = Externclass::id_generator($requisitou,'id');
        $requisitou->factor = trim($line->factorderiesgoaspecto);
        $requisitou->categoria = trim($line->categoriaderiesgo);        
        $requisitou->tipo_norma = trim($line->tipodenorma);
        $requisitou->norma = trim($line->numero);
        $requisitou->emision = trim($line->anodeemision);
        $requisitou->autoridad = trim($line->autoridadquelaemite);
        $requisitou->articulo = trim($line->articuloqueaplica);
        $requisitou->tipo_matriz = trim($line->grupotema);        
        $requisitou->description = $this->descp_writer($type,$info_string);
        $requisitou->empresa = Cache::get('empresa');
        $requisitou->nrelacionadas = $line->normasrelacionadas;
        $requisitou->descnorma = $line->descnorma;
        $requisitou->litnum = trim($line->literal);
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
            $requisitou->fechaprox = $line->fechaproxima;
        }

        $requisitou->status = 0; 

        $query_cond = RequisitosUnsaved::where('articulo','LIKE',"%".$requisitou->articulo."%")->where('norma','=',$requisitou->norma)->where('tipo_norma','LIKE',"%".$requisitou->tipo_norma."%")->where('litnum','LIKE',"%".$requisitou->literal."%")->where('empresa','=',$empresa)->first();
        if($query_cond==null){

            try{
                $requisitou->save();    
            }
            catch(\Exception $e)
            {
                $dataset = DB::select(DB::raw("select max(id) as id from Requisitos_unsaved")); 
                $id = 1+$dataset[0]->id;
                $requisitou->id = $id;
                $requisitou->save();
            }  
                     
        }
        else{
            //echo 'error repetido';
            return 'error_repetido';
        }        

    }

    public function descp_writer($type,$string){   
        if($type == "auto"){
            $string = "Error(es) detectado ".$string;
        }
        if($type == "unkn"){
            $string = "error sql ".$string;
        }
        return $string; 
    }

         
    public function new_requisito($line)
    {        
        $line->grupotema = trim($line->grupotema);
        $line->tipodenorma = trim($line->tipodenorma);
        $line->categoriaderiesgo = trim($line->categoriaderiesgo);
        $line->factorderiesgoaspecto = trim($line->factorderiesgoaspecto);
        $line->autoridadquelaemite = trim( $line->autoridadquelaemite);
        $line->numero = trim($line->numero);
        $line->articuloqueaplica = trim($line->articuloqueaplica);
        $line->anodeemision = trim($line->anodeemision);
        $line->literal = trim($line->literal);

        $empresa = Cache::get('empresa');
         
        $grupo = $this->identifygrupo($line->grupotema);

        //echo 'grupo '.$grupo;        
       
        $factorid = Factores::where('nombre','=',$line->factorderiesgoaspecto)->where('id_Tipo_matriz','=',$grupo)->value('id');
        if($factorid==null){
            //echo 'crear factor';
            $factorid = $this->create_factor($line,$grupo);
        }
        
        $categoriaid = Categorias::where('nombre','=',$line->categoriaderiesgo)->where('id_Factores','=',$factorid)->value('id');
        
        if($categoriaid==null){            
            
            $categoriaid = $this->create_categoria($line,$factorid);
        }

        $tp_normaid = Tiponorma::where('nombre','=',$line->tipodenorma)->value('id');
        if($tp_normaid==null){
            
            $tp_normaid = $this->create_tpnorma($line);
        }
        $autoridadid = Autoridad::Where('nombre',"=",$line->autoridadquelaemite)->value('id');
        if($autoridadid==null){
            
            $autoridadid = $this->create_autoridad($line);
        }
        $yearid = Year::Where('year',"LIKE",'%'.$line->anodeemision.'%')->value('id');          
        if($yearid==null){
            
            $yearid = $this->create_year($line);
        }
        $normaid = Normas::where('numero','=',$line->numero)->where('id_Tipo_norma','=',$tp_normaid)->where('id_Emision','=',$yearid)->value('id');
        if($normaid==null)
        {
            
            $normaid = $this->create_norma($line,$tp_normaid,$autoridadid,$yearid);
        }
        else{
            $this->update_norma($normaid,$line);
        }      
        $articuloid = Articulos::where('numero','=',$line->articuloqueaplica)->where('id_Normas','=',$normaid)->value('id');
        if($articuloid==null){
            $articuloid = $this->create_articulo($normaid,$line);
        }
        
        $littext = $this->semantica_noaplica($line->literal);
        if($line->literal==null or $littext==True)
        {
            $query_cond = Requisitos::where('id_Articulos','=',$articuloid)->where('id_empresa','=',$empresa)->where('id_Categorias','=',$categoriaid)->where('id_Literales','=',null)->first();
            $literalid = null;
        }
        else{
            $literalid = Literales::where('numero','=',$line->literal)->where('id_Articulos','=',$articuloid)->value('id');
            if($literalid==null){
                $literalid = $this->create_literal($articuloid,$line);
            }

            $query_cond = Requisitos::where('id_Articulos','=',$articuloid)->Where('id_Literales','=',$literalid)->where('id_empresa','=',$empresa)->first();           
        }
        if($query_cond==null)
        {
            $requisito = new Requisitos;
            $id = Externclass::id_generator($requisito,'id');            
            $requisito->id = $id;
            $requisito->id_Categorias = $categoriaid;                                               
            $requisito->id_Articulos = $articuloid;           
            $requisito->id_empresa = $empresa;
            $requisito->id_Literales = $literalid;
            $requisito->reqlegal = $line->requisitolegal;    
            $requisito->esperada = $line ->evidenciaesperada;
            $requisito->responsable = $line ->cargocumplimiento;
            $requisito->area = $line->areadeaplicacion;
            $requisito->id_Clase_norma = $this->assign_classn($line);
            $requisito->nrelacionadas = $line->normasrelacionadas;
            $string = 'subido';   
            //CONDICION SI YA HICE EL PROCESO       
        }
        else
        {
            $id = $query_cond->id;            
            $requisito = Requisitos::find($query_cond->id);
            $requisito->id_Categorias = $categoriaid;  
            $requisito->reqlegal = $line->requisitolegal;    
            $requisito->esperada = $line ->evidenciaesperada;
            $requisito->responsable = $line ->cargocumplimiento;
            $requisito->area = $line->areadeaplicacion;            
            $requisito->nrelacionadas = $line->normasrelacionadas;         
            $string = 'existe';                                    
        }

         /* $requisito->save();                       
            if($line->fechaevaluacion != null and $line->calificacion != null and $line->fechaproxima!= null)
            {
                $this->new_evaluation($line,$id);
            } */  
        try
        {
            try{
                $requisito->save();    
            }
            catch(\Exception $e)
            {
                $dataset = DB::select(DB::raw("select max(id) as id from Requisitos")); 
                $id = 1+$dataset[0]->id;
                $requisito->id = $id;
                $requisito->save();
            }                                               
                                   
            if($line->fechaevaluacion != null and  $line->fechaproxima!= null)
            {
                $this->new_evaluation($line,$id);
            }               
                               

        }
        catch(\Exception  $e)
        {
           $mistake = $this->register_unsavedreq($line,'unkn',$e);
           if($mistake=='error_repetido')
           {
            $string = 'error_repetido';
           }
           else{
             $string = 'error';    
           }
            
        }
        return $string;
    }

    public function identifygrupo($string)
    {
        $grupo = Tipomatriz::where('nombre','LIKE','%'.$string.'%')->value('id');
        return $grupo;
    }

    
    public function create_factor($line,$foid){
        $new_factor = new Factores;        
        $id  = Externclass::id_generator($new_factor,'id');
        $new_factor->id = $id;
        $new_factor->id_Tipo_matriz = $foid;
        $new_factor->nombre = $line->factorderiesgoaspecto;
        try{
            $new_factor->save();    
        }
        catch(\Exception $e)
        {
            $dataset = DB::select(DB::raw("select max(id) as id from Factores")); 
            $id = 1+$dataset[0]->id;
            $new_factor->id = $id;
            $new_factor->save();
        }                
        return $id;
    }    

    public function create_categoria($line,$foid){
        $new_categoria = new Categorias;
        $id = Externclass::id_generator($new_categoria,'id');        
        $new_categoria->id = $id;
        $new_categoria->nombre =  $line->categoriaderiesgo;
        $new_categoria->id_Factores = $foid;
        try{
            $new_categoria->save();    
        }
        catch(\Exception $e)
        {
            $dataset = DB::select(DB::raw("select max(id) as id from Categorias")); 
            $id = 1+$dataset[0]->id;
            $new_categoria->id = $id;
            $new_categoria->save();
        }
                
        return $id;        
    }

    public function create_tpnorma($line){
        $new_tp = new Tiponorma;
        $id = Externclass::id_generator($new_tp,'id');
        $new_tp->id=$id;
        $new_tp->nombre = $line->tipodenorma;
        try{
            $new_tp->save();    
        }
        catch(\Exception $e)
        {
            $dataset = DB::select(DB::raw("select max(id) as id from Tipo_norma")); 
            $id = 1+$dataset[0]->id;
            $new_tp->id = $id;
            $new_tp->save();
        }        
        return $id;
    }
    public function create_autoridad($line){
        $new_au = new Autoridad;
        $id = Externclass::id_generator($new_au,'id');
        $new_au->id = $id;
        $new_au->nombre = $line->autoridadquelaemite;
        try{
            $new_au->save();    
        }
        catch(\Exception $e)
        {
            $dataset = DB::select(DB::raw("select max(id) as id from Autoridad_emisora")); 
            $id = 1+$dataset[0]->id;
            $new_au->id = $id;
            $new_au->save();
        }

        return $id;  
    }
    public function create_year($line){
        $new_y = new Year;
        $id = Externclass::id_generator($new_y,'id');
        $new_y->id = $id;
        $new_y->year = $line->anodeemision;
        
        try{
            $new_y->save();    
        }
        catch(\Exception $e)
        {
            $dataset = DB::select(DB::raw("select max(id) as id from Emision")); 
            $id = 1+$dataset[0]->id;
            $new_y->id = $id;
            $new_y->save();
        }
        
        return $id;

    }
    public function create_norma($line,$tp_norma,$aut,$year){
        $new_n = new Normas;
        $id = Externclass::id_generator($new_n,'id');
        $new_n->id = $id;
        $new_n->numero = $line->numero;
        $new_n->id_Tipo_norma = $tp_norma; 
        $new_n->id_Autoridad_emisora = $aut;
        $new_n->id_Emision = $year;
        $new_n->descripcion = $line->descnorma;
        $new_n->id_Estados_vigencia = 1;    
        try{
            $new_n->save();    
        }
        catch(\Exception $e)
        {
            $dataset = DB::select(DB::raw("select max(id) as id from Normas")); 
            $id = 1+$dataset[0]->id;
            $new_n->id = $id;
            $new_n->save();
        }

        return $id;
    }

    public function update_norma($id,$line){
        $unorma = Normas::where('id','=',$id)->first();
        $unorma->descripcion = $line->descnorma;        
        $unorma->save();
    }

    public function create_articulo($foid,$line)
    {
        $new_ar = new Articulos;
        $id = Externclass::id_generator($new_ar,'id');
        $new_ar->id = $id;
        $new_ar->id_Normas = $foid;
        $new_ar->numero = $line->articuloqueaplica;
        $new_ar->id_Estados_vigencia = 1;         
        try{
            $new_ar->save();    
        }
        catch(\Exception $e)
        {
            $dataset = DB::select(DB::raw("select max(id) as id from Articulos")); 
            $id = 1+$dataset[0]->id;
            $new_ar->id = $id;
            $new_ar->save();
        }
        return $id;
    }

    public function create_literal($foid,$line)
    {
        $new_lit = new Literales;
        $id = Externclass::id_generator($new_lit,'id');
        $new_lit->id = $id;
        $new_lit->id_Articulos = $foid;
        $new_lit->numero = $line->literal;        
        $new_lit->id_Estados_vigencia = 1; 
         try{
            $new_lit->save();    
        }
        catch(\Exception $e)
        {
            $dataset = DB::select(DB::raw("select max(id) as id from Literales")); 
            $id = 1+$dataset[0]->id;
            $new_lit->id = $id;
            $new_lit->save();
        }
        $new_lit->save();
        
        return $id;
    }



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

    public function semantica_noaplica($string){
        $string = strtoupper($string);
        //echo $string;
        $aprox = similar_text($string,"NO APLICA",$percent);
        
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
        $aprox2 = similar_text($string,"TODAS",$percent2);
        
        if($percent>70 or $percent2>60){
            return True;
        }
        else{
            return False;
        }
    }

    public function assign_classn($line)
    {
        if($line->informativa!=null or $line->derogada!=null)
        {
            return 1;
        }
        else{
            return 2;
        }
    }

    public function new_evaluation($line,$foid)
    {                           
        $eval_update = Evaluacion::where('fecha','=',$line->fechaevaluacion)->where('id_Requisitos','=',$foid)->first();
        if($eval_update == null)
        {
            $evaluation = new Evaluacion;           
            $dataset = DB::select(DB::raw("select max(id) as id from Evaluacion")); 
            $id = 1+$dataset[0]->id;
            $evaluation->id = $id;
            $evaluation->fecha = $line->fechaevaluacion;
            $evaluation->calificacion = $line->calificacion;
            $evaluation->cumplimiento = $line->evidenciacumplimiento;
            $evaluation->id_Requisitos = $foid;
            $evaluation->usuario  = $this->usuario;
            $evaluation->fecha_prox = $line->fechaproxima;        
            
        }
        else{
            $evaluation = $eval_update;
            $evaluation->calificacion = $line->calificacion;
            $evaluation->cumplimiento = $line->evidenciacumplimiento;            
            $evaluation->usuario  = $this->usuario;
            $evaluation->fecha_prox = $line->fechaproxima;
        }

       // $evaluation->save();   

        try
        {
            $evaluation->save();   
        }
        catch(\Exception $e)
        {
            echo "Existe un error en la información de evaluación <br>";
        }           
                                
    }

    public function index(){
        $empresas = $this->empresas;
        $tiposmatriz = Tipomatriz::lists('nombre','id');
        $tiposnorma = Tiponorma::select(DB::RAW("id ,nombre"))->orderBy('nombre')->get();        
        $years = Year::select(DB::RAW("id ,year"))->orderBy('year')->get();
        $autoridades = Autoridad::select(DB::RAW("id ,nombre"))->orderBy('nombre')->get();
        $clases = ClaseNorma::lists('nombre','id');
        return view('Matriz.vrequisitos',compact('empresas','tiposmatriz','tiposnorma','years','autoridades','clases'));
    }

    public function filter_versions($id)
    {
        $query = "select DISTINCT fecha from Evaluacion as eval INNER JOIN Requisitos as req on eval.id_Requisitos = req.id where req.id_empresa = ".$id." order by fecha desc";
        $versiones =  DB::select(DB::raw($query)); 
        return $versiones;
    }

    public function filter_enterprise($empresa)
    {
        $condition = "idempresa = ".$empresa;        
        $main_query = $this->matriz_query($condition);

        $requisitos = DB::select(DB::raw($main_query));

        $ent_name = Empresa::where('idempresa','=',$empresa)->value('nombre');

        $tipo_eval = Empresa::where('idempresa','=',$empresa)->value('calificacion');
 
        return view('Matriz.Ajax.list',compact('requisitos','ent_name','tipo_eval'));
    }

    public function asistant_repair_duplicate()
    {
        $empresa = $_GET['enterprise'];
        $articulo = $_GET['art'];
        $condition = "idempresa = ".$empresa." and a.id = ".$articulo." and r.id_Literales is null";        
        $main_query = $this->matriz_query($condition);

        $requisitos = DB::select(DB::raw($main_query));

        $ent_name = Empresa::where('idempresa','=',$empresa)->value('nombre');

        $tipo_eval = Empresa::where('idempresa','=',$empresa)->value('calificacion');
 
        return view('Matriz.Ajax.list3',compact('requisitos','ent_name','tipo_eval'));   
    }

    public function data_to_fix(){        
        $empresas = $this->empresas;
        return view('Matriz.unsaved',compact('empresas'));
    }

    public function filter_enterprise2($enterprise)
    {       
        $requisitos  = RequisitosUnsaved::Where('empresa','=',$enterprise)->where('status','=',0)->get();

        $tiposnorma = Tiponorma::orderBy('nombre')->get();
        
        return view('Matriz.Ajax.list2',compact('requisitos','tiposnorma'));
    }

    public function other_filters($empresa,$tipo_matriz,$factores,$categorias,$tipo_norma,$norma,$year,$articulos,$autoridad_emisora,$version,$estado_requisitos)
    {

        $condition = "idempresa = ".$empresa." ";

        if($tipo_matriz!="placeholder" && $tipo_matriz!="null")
        {
            $condition = $condition."and tm.id = ".$tipo_matriz." ";
        }   
        if($factores!="placeholder" && $factores!="null")
        {
            $condition = $condition."and f.id = ".$factores." ";
        }
        if($categorias!="placeholder" && $categorias!="null")
        {
            $condition = $condition."and c.id = ".$categorias." ";
        }
        if($tipo_norma!="placeholder" && $tipo_norma!="null")
        {
            if(($articulos != "null" and $articulos!="placeholder") or ($norma != "null" and $norma!="placeholder"))
            {
               // $tp = Tiponorma::Where('id','=',$tipo_norma)->value('nombre');
                //$tp = trim($tp);
                //$condition = $condition."and tp.nombre like '%".$tp."%' ";
                $condition = $condition."and tp.id = ".$tipo_norma." ";
            }
            else
            {
                $condition = $condition."and tp.id = ".$tipo_norma." ";
            }
            
        }
        if($norma!="placeholder" && $norma!="null")
        {
            if($articulos != "null" and $articulos!="placeholder")
            {
                //$no = Normas::Where('id','=',$norma)->value('numero');
                //$condition = $condition."and n.numero = '".$no."' ";
                $condition = $condition."and n.id = '".$norma."' ";
            }
            else
            {
                //$no = Normas::Where('id','=',$norma)->value('numero');
                //$condition = $condition."and n.numero = '".$no."' ";
                //$condition = $condition."and n.id = ".$norma." ";
                $condition = $condition."and n.id = ".$norma." ";
            }
        }
        if($year!="placeholder" && $year!="null")
        {
            $condition = $condition."and y.id = ".$year." ";
        }
        if($articulos!="placeholder" && $articulos!="null")
        {
            //$ar = Articulos::Where('id','=',$articulos)->value('numero');
            //$condition = $condition."and a.numero = '".$ar."' ";
            $condition = $condition."and a.id = ".$articulos." ";
        }
        if($autoridad_emisora!="placeholder" && $autoridad_emisora!="null")
        {
            $condition = $condition."and au.id = ".$autoridad_emisora." ";
        }
        if($version!="placeholder" && $version!="null")
        {
            $condition = $condition."and Fecha = '".$version."' ";
        }
                
        $main_query = $this->matriz_query($condition);

        //return  $main_query;


        $requisitos = DB::select(DB::raw($main_query));

        $ent_name = Empresa::where('idempresa','=',$empresa)->value('nombre');

        $tipo_eval = Empresa::where('idempresa','=',$empresa)->value('calificacion');

        return view('Matriz.Ajax.list',compact('requisitos','ent_name','tipo_eval','estado_requisitos'));
       
    }

    public function insertar_factor($value,$foid)
    {
      $verify = Factores::where('nombre','like','%'.$value.'%')->where('id_Tipo_matriz','=',$foid)->value('id');
      if($verify==null)
      {        
        $factor = new Factores;
        $id = Externclass::id_generator($factor,'id');
        $factor->id = $id;
        $factor->nombre = $value;
        $factor->id_Tipo_matriz = $foid;
        try{
            $factor->save();    
        }
        catch(\Exception $e)
        {
            $dataset = DB::select(DB::raw("select max(id) as id from Factores")); 
            $id = 1+$dataset[0]->id;
            $factor->id = $id;
            $factor->save();
        }
        
        return $id; 
      }
      else{        
        return $verify;
      }
      
    }

    public function insertar_categoria($value,$foid)
    {
       $verify = Categorias::where('nombre','like','%'.$value.'%')->where('id_Factores','=',$foid)->value('id');
       if($verify==null)
       {
           $categoria = new Categorias;        
           $dataset = DB::select(DB::raw("select max(id) as id from Categorias"));
           $id = $dataset[0]->id+1; 
           $categoria->id =  $id;
           $categoria->nombre = $value;
           $categoria->id_Factores = $foid;
            try{
                $categoria->save();    
            }
            catch(\Exception $e)
            {
                $dataset = DB::select(DB::raw("select max(id) as id from Categorias")); 
                $id = 1+$dataset[0]->id;
                $categoria->id = $id;
                $categoria->save();
            }
           
           return $id;
       }
       else{
        return $verify;
       } 
       
    }    

    public function insertar_tpnorma($value)
    {
       $verify = Tiponorma::where('nombre','=',$value)->value('id');
       if($verify==null)
       {        
           $tpnorma = new Tiponorma;
           $id = Externclass::id_generator($tpnorma,'id');
           $tpnorma->id = $id; 
           $tpnorma->nombre = $value;
           try{
                $tpnorma->save();    
            }
            catch(\Exception $e)
            {
                $dataset = DB::select(DB::raw("select max(id) as id from Tipo_norma")); 
                $id = 1+$dataset[0]->id;
                $tpnorma->id = $id;
                $tpnorma->save();
            }
           
           return $id;
       }
       else {
        return $verify;
       }
          
    }

    public function insertar_autoridad($value)
    {
        $verify = Autoridad::where('nombre','LIKE',"%".$value."%")->value('id');
        if($verify==null)
        {
            $autoridad = new Autoridad;
            $id = Externclass::id_generator($autoridad,'id');
            $autoridad->id = $id;
            $autoridad->nombre = $value;
            try{
                $autoridad->save();    
            }
            catch(\Exception $e)
            {
                $dataset = DB::select(DB::raw("select max(id) as id from Autoridad_emisora")); 
                $id = 1+$dataset[0]->id;
                $autoridad->id = $id;
                $autoridad->save();
            }            
            return $id;    
        }
        else{ return $verify;}
           
    }

    public function insertar_articulo($value,$foid)
    {
        $verify = Articulos::where('numero','like','%'.$value.'%')->where('id_Normas','=',$foid)->value('id');
        if($verify==null)
        {
            $articulo = new Articulos;
            $id = Externclass::id_generator($articulo,'id');
            $articulo->id = $id;
            $articulo->numero = $value;
            $articulo->id_Normas = $foid;
            $articulo->id_Estados_vigencia = 1;
            try{
                $articulo->save();    
            }
            catch(\Exception $e)
            {
                $dataset = DB::select(DB::raw("select max(id) as id from Articulos")); 
                $id = 1+$dataset[0]->id;
                $articulo->id = $id;
                $articulo->save();
            }          
            return $id;    
        }
        else{ return $verify;}
           
    }

    public function insertar_literal($value,$foid)
    {   
        $verify = Literales::where('numero','like','%'.$value.'%')->where('id_Articulos','=',$foid)->value('id');
        if($verify==null)
        {
            $literal = new Literales;
            $dataset = DB::select(DB::raw("select max(id) as id from Literales"));
            $id = $dataset[0]->id+1; 
            $literal->id = $id;
            $literal->numero = $value;
            $literal->id_Articulos = $foid;
            try{
                $literal->save();    
            }
            catch(\Exception $e)
            {
                $dataset = DB::select(DB::raw("select max(id) as id from Literales")); 
                $id = 1+$dataset[0]->id;
                $literal->id = $id;
                $literal->save();
            } 

            return $id;
        }
        else{ return $verify;}      
    }

    public function insertar_norma($value,$tp,$y,$au)
    {
        $verify = Normas::where('numero','like','%'.$value.'%')->where('id_Tipo_norma','=',$tp)->where('id_Emision','=',$y)->where('id_Autoridad_emisora','=',$au)->value('id');
        if($verify==null)
        {
            $norma = new Normas;
            $id = Externclass::id_generator($norma,'id');
            $norma->id = $id;
            $norma->numero = $value;
            $norma->id_Tipo_norma = $tp;
            $norma->id_Emision= $y;
            $norma->id_Autoridad_emisora = $au;
            $norma->id_Estados_vigencia = 1;
            try{
                $norma->save();    
            }
            catch(\Exception $e)
            {
                $dataset = DB::select(DB::raw("select max(id) as id from Normas")); 
                $id = 1+$dataset[0]->id;
                $norma->id = $id;
                $norma->save();
            }           
            
            return $id;
        }
        else{ return $verify;}  
    }

    public function create_requisito(Request $request)
    {
      

        if($request->literal==null)
        {
            $verify = Requisitos::where('id_Categorias','=',$request->categoria)->where('id_Articulos','=',$request->articulo)->where('id_empresa','=',$request->infoempresa)->where('id_Literales','=',null)->first();
        }
        else{
            $verify = Requisitos::where('id_Categorias','=',$request->categoria)->where('id_Articulos','=',$request->articulo)->where('id_empresa','=',$request->infoempresa)->where('id_Literales','=',$request->literal)->first();
        }

        if($verify==null)
        {
            $requisito = new Requisitos;
            $id = Externclass::id_generator($requisito,'id');            
            $requisito->id = $id;
            $requisito->id_Categorias = $request->categoria;                                               
            $requisito->id_Articulos = $request->articulo;           
            $requisito->id_empresa = $request->infoempresa;
            $requisito->id_Literales = $request->literal;
            $requisito->reqlegal = $request->reqlegal;    
            $requisito->esperada = $request->esperada;
            $requisito->responsable = $request->responsable;
            $requisito->area = $request->area;
            $requisito->id_Clase_norma = $request->clase;
            
            //return $requisito;
            try{
                $requisito->save();    
            }
            catch(\Exception $e)
            {
                $dataset = DB::select(DB::raw("select max(id) as id from Requisitos")); 
                $id = 1+$dataset[0]->id;
                $requisito->id = $id;
                $requisito->save();
            } 

            echo "Requisito creado";
            
            //return redirect('matriz/matrices')->with('message','stored');    
        }
        else{
            echo "Ya existe un requisito similar al que intenta guardar";
            //return redirect('matriz/matrices')->with('message','repeated');   
        }        
        
   }

   public function edit_requisito($id)
   {
        $requisito = DB::select(DB::raw("select tpn.id as tipon, n.id as norma, a.id as articulo, tpm.id as tipom, f.id as factor, id_Literales as literal, id_Categorias as categoria ,reqlegal, esperada, responsable, area, id_Clase_norma as clase from Requisitos as r INNER JOIN Categorias as c on r.id_Categorias = c.id inner join Factores as f on c.id_Factores = f.id INNER JOIN Tipo_matriz as tpm on f.id_Tipo_matriz = tpm.id left join Literales as l on r.id_Literales = l.id INNER JOIN Articulos as a on r.id_Articulos = a.id INNER JOIN Normas as n on n.id=a.id_Normas INNER JOIN Tipo_norma as tpn on tpn.id = n.id_Tipo_norma where r.id = ".$id));        

        return $requisito;
   }

   public function update_requisito( Request $request, $id)
   {

        $requisito = Requisitos::find($id);
        if($request->literal==null)
        {
            $verify = Requisitos::where('id_Categorias','=',$request->categoria)->where('id_Articulos','=',$request->articulo)->where('id_empresa','=',$request->infoempresa)->where('id','!=',$id)->value('id');            
            $literal = null;
        }
        else{
            $verify = Requisitos::where('id_Categorias','=',$request->categoria)->where('id_Articulos','=',$request->articulo)->where('id_empresa','=',$request->infoempresa)->where('id_Literales','=',$request->literal)->where('id','!=',$id)->value('id');
            $literal = $request->literal; 
        }

        //return $requisito;

        if($verify==null)
        {
            //return $request->reqlegal;        
            $requisito->id_Categorias = $request->categoria;                                               
            $requisito->id_Articulos = $request->articulo;            
            $requisito->id_Literales = $literal;
            $requisito->reqlegal = $request->reqlegal;    
            $requisito->esperada = $request->esperada;
            $requisito->responsable = $request->responsable;
            $requisito->area = $request->area;
            $requisito->id_Clase_norma = $request->clase;
            //return $requisito;
            $requisito->save();
            //return redirect('matriz/matrices')->with('message','updated');
            echo "Requisito editado";
        }
        else{
            //return redirect('matriz/matrices')->with('message','repeated');
            echo "Requisito repetido";   
        }    
   }

   public function delete_requisito($id)
   {
        $evaluacion = Evaluacion::where("id_Requisitos",'=',$id)->first();        
        DB::delete("delete from Evaluacion where id_Requisitos = ".$id);             
        
        DB::delete("delete from Requisitos where id = ".$id);

        return redirect('matriz/matrices')->with('message','deleted');

   }

   public function pass_data($id)
   {
     $val = Empresa::where('nombre','like','validaciones')->value('idempresa');
     $validaciones = Requisitos::where('id_empresa','=',$val)->get();     
     foreach ($validaciones as $validacion){
         if($validacion->id_Literales!=null)
         {
            $query_cond = Requisitos::where('id_Articulos','=',$validacion->id_Articulos)->Where('id_Literales','=',$validacion->id_Literales)->where('id_empresa','=',$id)->where('id_Categorias','=',$validacion->id_Categorias)->first();
         }
         else{
             $query_cond = Requisitos::where('id_Articulos','=',$validacion->id_Articulos)->where('id_empresa','=',$id)->where('id_Categorias','=',$validacion->id_Categorias)->where('id_Literales','=',null)->first();
         }
         if($query_cond == null)
         {
            $validacion->id_empresa = $id;
            $validacion->save();   
         }
         else{
             DB::delete("delete from Evaluacion where id_Requisitos = ".$validacion->id);
             DB::delete("delete from Requisitos where id = ".$validacion->id);
         }         
     }
     return redirect('matriz/matrices')->with('message','passed');
   }

   public function pass_data2($id)
   {
     $val = Empresa::where('nombre','like','validaciones')->value('idempresa');
     $validaciones = RequisitosUnsaved::where('empresa','=',$val)->get();     
     foreach ($validaciones as $validacion){
         
        $query_cond = RequisitosUnsaved::where('articulo','LIKE',"%".$validacion->articulo."%")->where('norma','=',$validacion->norma)->where('tipo_norma','LIKE',"%".$validacion->tipo_norma."%")->where('litnum','LIKE',"%".$validacion->literal."%")->where('empresa','=',$id)->first();
        if($query_cond == null)
        {
         $validacion->empresa = $id;
         $validacion->save();
        }
        else{
            DB::delete("delete from Requisitos_unsaved where id = ".$validacion->id);
        } 
     }
     return redirect('matriz/arreglos')->with('message','passed');
   }            

   public function make_evaluation(Request $request)
   {
        //return $request->reqs_to_eval;
        $array = explode(',', $request->reqs_to_eval);

        foreach($array as $arr)
        {
            $query = "Select a.id_Estados_vigencia as estado from Requisitos as r inner join Articulos as a  on 
            r.id_Articulos = a.id where r.id = $arr";
            //echo $query;
            $current_req = DB::select(DB::raw($query));
             if($current_req[0]->estado == 2)
            {
                return "Uno de los articulos de los requisitos a evaluar esta derogado, vuelva a intentarlo";
                //return redirect('matriz/matrices')->with('message','no_allowed_der'); 
            }
        }

        //return "";

        foreach($array as $arr)
        {
            $mytime = Carbon\Carbon::now();
            $Fecha = $mytime->format('Y-m-d');
            $eval_update = Evaluacion::where('fecha_prox','=',$request->fechaprox)->where('id_Requisitos','=',$arr)->first();
            if($eval_update == null)
            {
                $evaluation = new Evaluacion;
                $dataset = DB::select(DB::raw("select max(id) as id from Evaluacion")); 
                $id = 1+$dataset[0]->id;
                $evaluation->id = $id;            
                $evaluation->fecha = $request->fecha;
                $evaluation->calificacion = $request->calificacion;
                $evaluation->cumplimiento = $request->evidenciacump;
                $evaluation->id_Requisitos = $arr;
                $evaluation->usuario  = $this->usuario;
                $evaluation->fecha_prox = $request->fechaprox;        
                $evaluation->save();
            }
            else{
                $eval_update->fecha = $request->fecha;
                $eval_update->calificacion = $request->calificacion;
                $eval_update->cumplimiento = $request->evidenciacump;
                $eval_update->usuario  = $this->usuario;
                $eval_update->fecha_prox = $request->fechaprox;        
                $eval_update->save();
            }

                      
        }

        return "Requisitos evaluados";

        //return redirect('matriz/matrices')->with('message','evaluated'); 
        
   }

   public function all_evals($id)
   {
        $evaluations = DB::SELECT(DB::raw("select * from Evaluacion where id_Requisitos = ".$id." and fecha not in (select MAX(fecha) from Evaluacion where id_Requisitos = ".$id.")"));
        return view('Matriz.Ajax.old_evals',compact('evaluations'));
   }

   public function evalinfo($id)
   {
       $evaluacion = Evaluacion::where("id_Requisitos",'=',$id)->orderBy('id','desc')->first();
       return $evaluacion;
   }

   public function nuevo_comentario(Request $request)
   {
        //return "aca";
        $comentario = new Comentario;
        //$dataset = DB::select(DB::raw("select max(id) as id from Evaluacion")); 
       // $id = 1+$dataset[0]->id;
       
        $titulo = $request->titulo;
        $comentario->titulo = $request->titulo;
        $comentario->comentario = $request->comentario;
        $incomentario = $request->comentario;
        if(!empty($request->archivo))
        {   
            $archivo = $request->file('archivo');
            $nombre_original=$archivo->getClientOriginalName();      
            $resource=Storage::disk('comentarios')->put($nombre_original,  \File::get($archivo) );
            $comentario->archivo = $nombre_original;
        } 
        $comentario->id_Requisitos = $request->requisito;
        $comentario->usuario_id = $this->usuario;

        $comentario->save(); 
        
        $requisito = $request->requisito;

        $empresa = Requisitos::where('id','=',$requisito)->value('id_empresa');

        $permisos = MailPermission::where("empresa",'=',$empresa)->first();
        if($permisos != null)
        {
            $usuarios = explode(",", $permisos->usuarios);
            foreach($usuarios as $usuario)
            {
                $user = Usuario::where('idusuario','=',$usuario)->first();
                Mail::send('Mail.layout.comment',compact('incomentario','titulo','requisito'), function($msj) use($user)
                    {
                        $msj->subject("Comentario en requisito");
                        $msj->to($user->correo); 
                    });

                $contents = view('Mail.layout.comment', compact('incomentario','titulo','requisito'))->render();

                //print_r($contents);
                $dataset = DB::select(DB::raw("select max(id) as id from correos")); 
                $correo_id = 1+$dataset[0]->id;

                $correo = new Correo();

                $correo->id = $correo_id;
                $correo->proceso = "Comentarios";
                $correo->emisor = Auth::user()->idusuario;                
                $correo->html = $contents;
                $correo->asunto = "Comentario en requisito";
                $correo->estado = 2;
                $correo->receptor = $usuario;
                $correo->save();    
            }
        }

        return "comentario guardado";

        //return redirect('matriz/matrices')->with('message','commented');
   }

   public function lista_comentarios($id)
   {
        $comentarios = Comentario::where('id_Requisitos','=',$id)->get();
        return view('Matriz.Ajax.comments',compact('comentarios'));
   }

   public function archivo_comentario($id)
   {
        $file = Comentario::where('id','=',$id)->value('archivo');
        
        if(file_exists(storage_path('comentarios/'.$file)))
        {
            $file_path = storage_path('comentarios/'.$file);
            return response()->download($file_path);
        
        }
   }

   public function delete_no_valid()
   {
        $val = Empresa::where('nombre','like','validaciones')->value('idempresa');
        $validaciones = Requisitos::where('id_empresa','=',$val)->get();
        foreach ($validaciones as $validacion){         
         DB::delete("delete from Evaluacion where id_Requisitos = ".$validacion->id);
         DB::delete("delete from Requisitos where id = ".$validacion->id);
        }
        return redirect('matriz/matrices')->with('message','erasedall');        
   }

   public function delete_no_valid_2()
   {
        $val = Empresa::where('nombre','like','validaciones')->value('idempresa');
        $validaciones = RequisitosUnsaved::where('empresa','=',$val)->get();
        foreach ($validaciones as $validacion){

         DB::delete("delete from Requisitos_unsaved where id = ".$validacion->id);
        }
        return redirect('matriz/arreglos')->with('message','erasedall');        
   }

   public function update_cump(Request $request)
   {
        //print_r($_POST);
        //return "";
        $requisito = Requisitos::find($request->id);
        $requisito->esperada = $request->evidencia;
        $requisito->area = $request->area;
        $requisito->responsable = $request->responsable;
        $requisito->nrelacionadas = $request->relacionada;
        $requisito->reqlegal = $request->reqlegal;
        $requisito->save();
        return "Actualizado";
   }

   public function replique_req(Request $request)
   {
        $copy_requisito = Requisitos::find($request->id);
        
        if($copy_requisito->id_empresa == $request->empresa)
        {
            return "ya existe el requisito en esa empresa";
        }

        $requisito = new Requisitos;
        $id = Externclass::id_generator($requisito,'id');            
        $requisito->id = $id;
        $requisito->id_Categorias = $copy_requisito->id_Categorias;                                               
        $requisito->id_Articulos = $copy_requisito->id_Articulos;           
        $requisito->id_empresa = $request->empresa;
        $requisito->id_Literales = $copy_requisito->id_Literales;
        $requisito->reqlegal = $copy_requisito->reqlegal;    
        $requisito->esperada = $copy_requisito->esperada;
        $requisito->responsable = $copy_requisito->responsable;
        $requisito->area = $copy_requisito->area;
        $requisito->id_Clase_norma = $request->clase;
        $requisito->nrelacionadas = $copy_requisito->nrelacionadas;
        $requisito->esperada = $copy_requisito->evidencia_esperada;      
        $requisito->reqlegal = $copy_requisito->requisito_legal;
        $requisito->responsable = $copy_requisito->responsable;
        $requisito->area = $copy_requisito->area;
        
        $verify = Requisitos::where('id_Categorias','=',$requisito->id_Categorias)->where('id_Articulos','=',$requisito->id_Articulos)->where('id_empresa','=',$requisito->id_empresa)->where('id_Literales','=',$requisito->id_Literales)->first();             
        if($verify == null)
        {
          $requisito->save();
          return "Requisito replicado";  
        }
        else
        {
            return "El requisito ya existe en esa empresa";
        }

        //print_r($_POST);
        //echo "<br>";
        //print_r($requisito);
        //
   }


   public function version4()
   {
        return view('Matriz.InterfazMatrizV4');
   }
}


