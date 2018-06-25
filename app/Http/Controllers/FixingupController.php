<?php

namespace Sig\Http\Controllers;

use Illuminate\Http\Request;

use Sig\Http\Requests;
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
use Sig\Models\Categorias;
use Sig\Models\Evaluacion;
use Sig\Helpers\Externclass;
use Sig\Helpers\Validation;
use Sig\Helpers\Permission;
use Auth;
use Storage;
use Cache;
use DB;
use Carbon;

class FixingupController extends Controller
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

    public function eliminar_requisito($id)
    {
          $fixing = RequisitosUnsaved::where('id','=',$id)->first();
          $fixing->status = 1;
          $fixing->save();
          return 'requisito de arreglos borrado';
    }

    public function manual_fixing()
    {
      
        $fixing = RequisitosUnsaved::where('id','=',$_POST['id'])->first();
        if(trim($_POST['norma'])==null or trim($_POST['articulo'])==null or trim($_POST['emision'])==null)
        {
            $cond8 = True;
            return 'aun hay errores en la información para subirlo'; 
        }
        else{
            $cond8 = False;
            
        }
        
        $cond1 = $this->semantica_na(trim($_POST['norma']));
        $cond2 = $this->semantica_na(trim($_POST['articulo']));
        $cond3 = $this->semantica_noaplica(trim($_POST['norma']));
        $cond4 = $this->semantica_noaplica(trim($_POST['articulo']));
        $cond5 = $this->strategy_mult(trim($_POST['articulo']));
        $cond6 = $this->semantica_todo(trim($_POST['articulo']));
        $cond7 = $this->semantica_na(trim($_POST['emision']));

        if($cond1 == True or $cond2 == True or $cond3 == True or $cond4 == True or $cond5 == True or $cond6 == True or $cond7 == True )
        {
            return 'aun hay errores en la información para subirlo';
        }

        //return 'sin errores';
     
        $empresa = $fixing->empresa;

        $tipomatriz = Tipomatriz::where('nombre','LIKE','%'.$fixing->tipo_matriz.'%')->value('id');        
        $factor = Factores::where('nombre','LIKE','%'.$fixing->factor.'%')->where('id_Tipo_matriz','=',$tipomatriz)->value('id');

        if($factor == null)
        {
            $factor = $this->insertar_factor($fixing->factor,$tipomatriz);
        }

        $categoria = Categorias::where('nombre','LIKE','%'.$fixing->categoria.'%')->where('id_Factores','=',$factor)->value('id');

        if($categoria == null)
        {
            $categoria = $this->insertar_categoria($fixing->categoria,$factor);
        }

        $tiponorma = Tiponorma::where('nombre','LIKE','%'.$fixing->tipo_norma.'%')->value('id');

        if($tiponorma == null)
        {
            $tiponorma = $this->insertar_tpnorma($fixing->tipo_norma);
        }

        $autoridad = Autoridad::where('nombre','LIKE',"%".$fixing->autoridad."%")->value('id');

        if($autoridad == null)
        {
            $autoridad = $this->insertar_autoridad($fixing->autoridad);
        }

        $emision = Year::where('year','LIKE','%'.trim($_POST['emision']).'%')->value('id');


        $norma =  Normas::where('numero','like','%'.trim($_POST['norma']).'%')->where('id_Tipo_norma','=',$tiponorma)->where('id_Emision','=',$emision)->where('id_Autoridad_emisora','=',$autoridad)->value('id');
         
        if($norma == null)
        {
            $norma = $this->insertar_norma(trim($_POST['norma']),$tiponorma,$emision,$autoridad,$fixing->descnorma);
        }

        $articulo = Articulos::where('numero','like','%'.trim($_POST['articulo']).'%')->where('id_Normas','=',$norma)->value('id');
            

        if($articulo == null)
        {
            $articulo = $this->insertar_articulo(trim($_POST['articulo']),$norma);
        }

        
        if(trim($_POST['literal'])!=null)
        {
             $literal = Literales::where('numero','like','%'.trim($_POST['literal']).'%')->where('id_Articulos','=',$articulo)->value('id');
             if($literal == null)
             {
                $literal = $this->insertar_literal(trim($_POST['literal']),$articulo);
             }

             $query_cond = Requisitos::where('id_Articulos','=',$articulo)->Where('id_Literales','=',$literal)->where('id_empresa','=',$empresa)->where('id_Categorias','=',$categoria)->first();
        }
        else{
            $literal = null;
            $query_cond = Requisitos::where('id_Articulos','=',$articulo)->where('id_empresa','=',$literal)->where('id_Categorias','=',$categoria)->where('id_Literales','=',null)->first();
        }
    
        if($query_cond==null)
        {
            $requisito = new Requisitos;
            $id = Externclass::id_generator($requisito,'id');            
            $requisito->id = $id;
            $requisito->id_Categorias = $categoria;                                               
            $requisito->id_Articulos = $articulo;           
            $requisito->id_empresa = $empresa;
            $requisito->id_Literales = $literal;
            $requisito->reqlegal = $fixing->reqlegal;    
            $requisito->esperada = $fixing->esperada;
            $requisito->responsable = null;
            $requisito->area = $fixing->area;
            $requisito->id_Clase_norma = $fixing->clase;
            $requisito->nrelacionadas = $fixing->nrelacionadas;
            $requisito->save();                       
                if($fixing->fecha != null and $fixing->fechaprox != null and $fixing->calif!= null)
                {
                    $this->new_evaluation($fixing,$id);
                }            
          
          $fixing->status = 1;
          $fixing->save();

            return 'requisito arreglado';                 
        }
        else{
          
          $fixing->status = 1;
          $fixing->save();
          
            return 'ya existe un requisito con estas características';
        }        
        
    }

     private function insertar_factor($value,$foid)
    {             
        $factor = new Factores;
        $id = Externclass::id_generator($factor,'id');
        $factor->id = $id;
        $factor->nombre = $value;
        $factor->id_Tipo_matriz = $foid;
        $factor->save();
        return $id;   
    }

    public function insertar_categoria($value,$foid)
    {       
       $categoria = new Categorias;        
       $dataset = DB::select(DB::raw("select max(id) as id from Categorias"));
       $id = $dataset[0]->id+1; 
       $categoria->id =  $id;
       $categoria->nombre = $value;
       $categoria->id_Factores = $foid;
       $categoria->save();
       return $id;       
    }    

    public function insertar_tpnorma($value)
    {       
       $tpnorma = new Tiponorma;
       $id = Externclass::id_generator($tpnorma,'id');
       $tpnorma->id = $id; 
       $tpnorma->nombre = $value;
       $tpnorma->save();
       return $id;         
    }

    public function insertar_autoridad($value)
    {
        $autoridad = new Autoridad;
        $id = Externclass::id_generator($autoridad,'id');
        $autoridad->id = $id;
        $autoridad->nombre = $value;
        $autoridad->save();
        return $id;         
    }

    public function insertar_articulo($value,$foid)
    {
        //echo 'ingrese a crear articulo';        
        $articulo = new Articulos;
        $id = Externclass::id_generator($articulo,'id');
        $articulo->id = $id;
        $articulo->numero = $value;
        $articulo->id_Normas = $foid;
        $articulo->id_Estados_vigencia = 1;
        $articulo->save();
        return $id;           
    }

    public function insertar_literal($value,$foid)
    {   
      
        $literal = new Literales;
        $dataset = DB::select(DB::raw("select max(id) as id from Literales"));
        $id = $dataset[0]->id+1; 
        $literal->id = $id;
        $literal->numero = $value;
        $literal->id_Articulos = $foid;
        $literal->id_Estados_vigencia = 1;
        $literal->save();
        return $id;
    }

    public function insertar_norma($value,$tp,$y,$au,$desc)
    {        
        $norma = new Normas;
        $id = Externclass::id_generator($norma,'id');
        $norma->id = $id;
        $norma->numero = $value;
        $norma->id_Tipo_norma = $tp;
        $norma->id_Emision= $y;
        $norma->id_Autoridad_emisora = $au;
        $norma->descripcion = $desc;
        $norma->id_Estados_vigencia = 1;
        $norma->save();
        return $id;     
    }


    public function new_evaluation($fixing,$foid)
    {                           
            
        $evaluation = new Evaluacion;
        $id = Externclass::id_generator($evaluation,'id');
        $evaluation->id = $id;
        $evaluation->fecha = $fixing->fecha;
        $evaluation->calificacion = $fixing->calif;
        $evaluation->cumplimiento = $fixing->cump;
        $evaluation->id_Requisitos = $foid;
        $evaluation->usuario  = $this->usuario;
        $evaluation->fecha_prox = $fixing->fechaprox;        
        $evaluation->save();                            
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
        
        if($percent>70){
            return True;
        }
        else{
            return False;
        }
    }

    public function strategy_mult($string)
    {       
        $text = trim($string);                 
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

    public function fixmatriz()
    {
        $requisitos = Requisitos::all();
        foreach($requisitos as $requisito)
        {
            $reqs = Requisitos::where('id_empresa','=',$requisito->id_empresa)->where('id_Articulos','=',$requisito->id_Articulos)->where('id_Literales','=',$requisito->id_Literales)->get();

            echo count($reqs);

            echo '<br>'; 
            
            if(count($reqs)>1)
            {
                $stay =  $reqs[count($reqs)-1];

                echo 'stay '.$stay->id;

                for($i=0; $i<(count($reqs)-1); $i++)
                {
                    echo 'a cambiar '.$reqs[$i]->id;
                    $evals = Evaluacion::where('id_Requisitos','=',$reqs[$i]->id)->get();
                    if($evals != null)
                    {
                        foreach($evals as $eval)
                        {
                            echo 'evaluacion '.$eval->id;
                            echo 'con requisito '.$eval->id_Requisitos;
                            DB::delete("delete from Evaluacion where id = ".$eval->id);
                            //$eval->id_Requisitos = $stay->id;
                            //echo 'cambiado '.$eval->id_Requisitos;
                            //$eval->save();   
                        }
                        
                    }
                    echo 'borrar '.$reqs[$i]->id;
                    DB::delete("delete from Requisitos where id = ".$reqs[$i]->id);
                    echo '<br>';
                }

            } 
            
        }
        return 'arreglar';
    }

    public function fixreq_tpnorma(Request $request)
    {
        $requisito = RequisitosUnsaved::where('id','=',$request->id)->first();
        $requisito->tipo_norma = $request->tp_norma;
        $requisito->save();
        return "Tipo de norma cambiado";
    }

    
}
