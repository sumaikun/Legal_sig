<?php
namespace sig\Http\Controllers;

use Illuminate\Http\Request;
use Sig\Models\Empresa;
use Sig\Http\Requests;
use Sig\Models\Industria;
use Sig\Models\Sector;
use Sig\Models\ClaseNorma;
use Sig\Models\Requisitos;
use Sig\Http\Controllers\Controller;
use Sig\Helpers\Externclass;
use Sig\Http\Requests\enterprise\EmpresaCreateRequest;
use Sig\Http\Requests\enterprise\EmpresaUpdateRequest;
use DB;
use Auth;
use Sig\Helpers\Permission;
use Sig\Helpers\Validation;
use Excel;
use Storage;
use Session;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
       public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Admin',['only'=>['index','edit','create','store','update']]);
        $this->middleware('consult',['only'=>['asignacionf','asignaciona']]);
    }
    
    public function index()

    {        
    $ents = Empresa::All();
    $sector = Sector::lists('sector','idsector');
    $industria = Industria::lists('industria','idindustria');

    return view('empresa.listar',compact('ents','sector','industria'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function create()
    {  
    $sector=Sector::lists('sector','idsector');
    return view('empresa.agregar',compact('sector')); 

    }

    public function getIndustria(Request $request,$id){

       // return "llego al controlador";
      if($request->ajax()){
        
            $industria = Industria::industrias($id);
            return response()->json($industria);
     
      }
    }

    public function getIndustria_edit(Request $request,$id,$num){

      
       // return "llego al controlador";
      if($request->ajax()){
        
            $industria = Industria::industrias($num);
            return response()->json($industria);
     
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpresaCreateRequest $request)
    {  
    /* $datos_validar=["nombre" => $request->nombre,
               "representante_legal" => $request->representante_legal,
               "cargo" => $request->cargo,];

               return $datos_validar;    */     
            

            $validar = $request['tipoevaluacion'];

            //return "retorna ".$validar;

            $sector=$_POST['sector'];
              

             $industria=$_POST['industria'];

             if($sector==null || $industria == null)
             {
                return redirect('/Empresa/create')->with('message','invalid');
             }

             else {

                  $sectorint = (int)$sector;
                  $industriaint = (int)$industria;
                  $usuario = Auth::user()->idusuario;

                              //return "dame este valor ".$sectorint;     
                  Empresa::create([
                     
                  'nombre' =>$request['nombre'],
                  'representante_legal'=> $request['representante_legal'],
                  'cargo'=>$request['cargo'], 
                  'comentario' => $request['comentario'],
                  'sector_id' => $sectorint,
                  'industria_id' => $industriaint,
                  'path'=> $request['logo'],
                  'calificacion'=> $request['tipoevaluacion'],
                  'Usuario'=>$usuario]);

                      return redirect('/Empresa')->with('message','store');
                }    
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {

        $ents =Empresa::find($id);
        return view('empresa.cambiarEstado',['ents'=>$ents]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
        $ents = Empresa::find($id);
        $sectores = Sector::lists('sector','idsector');     
        $intg2 = true;
        return view('empresa.modificar',['ents'=>$ents,'sectores'=>$sectores,'intg2'=>$intg2]);

        
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmpresaUpdateRequest $request, $id)
    {

            $usuario = Auth::user()->idusuario;

            $ents = Empresa::find($id);
                    
            $ents->nombre = $request['nombre'];
            $ents->representante_legal = $request['representante_legal'];
            $ents->cargo = $request['cargo'];

            if($request['sector']!=null)
            {
              $ents->sector_id = $request['sector'];  
            }   
            if($request['industria']!=null)
            {
              $ents->industria_id = $request['industria'];  
            }  
            if($request['comentario']!=null)
            {
              $ents->comentario = $request['comentario']; 
            }            
            if($request['tipoevaluacion']!=null)
            {
              $ents->calificacion = $request['tipoevaluacion'];  
            }  
            $ents->Usuario = $usuario;
            

            if($request['logo']!=null)
            {
                $table = new Empresa();
                $property = 'idempresa';
                $argument = $id;
                $file = 'path';

              Externclass::deletefiles($table,$property,$argument,$file,'local');

              $ents-> fill(['path' => $request['logo'], ]);
            }    
            
            $ents-> save();
            return redirect('/Empresa')->with('message','update');
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    {        
        
         //,['user'=>$user]);
    }
    public function asignacionf()
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
        $totalFactores=FactorRiesgo::count('idfactor_riesgo');
        $Factores=FactorRiesgo::lists('nombre','idfactor_riesgo');
        $ents = Empresa::All();
        $switch = 1;
     
        return view ('empresa.permisosfactor',compact('empresas','totalFactores','Factores','ents','switch'));

    }

        public function asignaciona()
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
        $totalFactores=AspectoAmbiental::count('id');
        $Factores=AspectoAmbiental::lists('nombre','id');
        $ents = Empresa::All();
        $intg2 = true;
        $switch = 2;
        return view ('empresa.permisosfactor',compact('empresas','totalFactores','Factores','ents','intg2','switch'));

    }

    public function insertarfactor(Request $request)
    {
        $empresa = $_POST['empresa']; 

        if($empresa != null)
        {     
                $totalFactores =FactorRiesgo::count('idfactor_riesgo');

                $numeros=array();
                for($i=1;$i<$totalFactores+1;$i++)
                {
                    if( $request['factor'.$i]!=null)
                    {
                        $dato = $_POST['factor'.$i];
                        array_push($numeros, $dato);
                    }
                }
                $ents = Empresa::find($empresa);

                 if($numeros==null)
                 {                    
                    $ents-> fill([       
                    'factores' =>"Ninguno",
                    ]);
                  }
                 else
                {
                    $valorfactor = implode(",", $numeros);
                    $ents-> fill([       
                    'factores' =>$valorfactor,
                    ]);
                }

                $ents-> save();
                return redirect('/AsignacionFactores')->with('message','update');    
           }
           
           else {   
           return redirect('/AsignacionFactores')->with('message','invalid');
           }
        //return var_dump($numeros);
    }

    public function checkedfactores($id)
    {
        $query = Empresa::Where('idempresa','=',$id)->value('factores');
        return $query;
    }

        public function checkedaspecto($id)
    {
        $query = Empresa::Where('idempresa','=',$id)->value('aspectos');
        return $query;
    }

    public function insertaraspecto(Request $request)
    {
        $empresa = $_POST['empresa'];
        if($empresa != null)
        {  
            $totalFactores =AspectoAmbiental::count('id');

            $numeros=array();
            for($i=1;$i<$totalFactores+1;$i++)
            {
                if( $request['factor'.$i]!=null)
                {
                    $dato = $_POST['factor'.$i];
                    array_push($numeros, $dato);
                }
            }

            $ents = Empresa::find($empresa);    
            if($numeros==null)
             {                    
                $ents-> fill([       
                'aspectos' =>"Ninguno",
                ]);
              }
            else {
               $valorfactor = implode(",", $numeros);
                //return $valorfactor."empresa".$ents;
                $ents-> fill([       
                'aspectos' =>$valorfactor,
                ]); 
            }
                              
            $ents-> save();
            return redirect('/AsignacionAspectos')->with('message','update2');
         }  
            
         else {   
           return redirect('/AsignacionAspectos')->with('message','invalid');
           }
        //return var_dump($numeros);
    }


    public function visualize()
    {
        $ents = Empresa::All();
        $factor =FactorRiesgo::lists('factor','idfactor_riesgo');    
        return view('empresa.listpermisos',compact('ents','factor'));

    } 

    public function Selectenterprise($id , $con)
    {
        if(Auth::user()->rol_id==3 or Auth::user()->rol_id==2)
        {
           
            $array = Permission::Permission_array();
            $empresas=Empresa::Wherein('idempresa',$array)->lists('nombre','idempresa'); 
        }   
        else
        {     
            $empresas=Empresa::lists('nombre','idempresa');
        }
        return view('empresa.select',compact('empresas','id','con'));        
    }

    public function exportar($id,$tipo)
    {  
          $empresas = Empresa::lists('nombre','idempresa');          

           $query = "select Fecha = (select MAX(Evaluacion.fecha)  from Evaluacion LEFT JOIN Requisitos on Evaluacion.id_Requisitos = Requisitos.id where Requisitos.id = r.id ) as conditioner, r.id as id ,tm.nombre as Tipo, f.nombre as Factor , c.nombre as Categoria, tp.nombre as Tpnorma , au.nombre as Autoridad , y.`year` as Emision , n.numero as Numero , a.numero as Articulo , es.nombre as Estado, l.numero as Literal , n.descripcion as Descnorma , r.nrelacionadas as Nrelacionadas ,r.reqlegal as Reqlegal , r.esperada as Esperada , r.area as Area , r.responsable as Cargo , cl.nombre as Clase , eval.fecha as Fecha , eval.cumplimiento as Cumplimiento , eval.Calificacion as Calif , eval.fecha_prox as Prox from Requisitos as r inner JOIN empresa as e on r.id_empresa = e.idempresa INNER JOIN Categorias as c on c.id = r.id_Categorias INNER JOIN Factores as f on f.id = c.id_Factores INNER JOIN Tipo_matriz as tm on tm.id = f.id_Tipo_matriz INNER JOIN Articulos as a on a.id = r.id_Articulos INNER JOIN Normas as n on n.id = a.id_Normas  INNER JOIN Tipo_norma as tp on tp.id=n.id_Tipo_norma INNER JOIN Autoridad_emisora as au on au.id = n.id_Autoridad_emisora INNER JOIN Emision as y on y.id = n.id_Emision INNER JOIN Clase_norma as cl on cl.id = r.id_Clase_norma INNER JOIN Estados_vigencia as es on es.id = a.id_Estados_vigencia  LEFT JOIN Literales as l on l.id = r.id_Literales LEFT JOIN Evaluacion as eval on eval.id_Requisitos = r.id  where r.id_empresa= ".$id." and tm.id = ".$tipo."  and r.deleted_at is null having conditioner = 1 or conditioner is null ORDER BY id ";

            try {
              $export = DB::select(DB::raw($query));  
            }
            catch(\Exception  $e)
            {
              return 'seleccione un tipo de matriz valido';
            }            

           //return $export;  

              $order = Array ('Factor','Categoria','Tipo','Descnorma','Tpnorma','Numero','Emision','Autoridad','Articulo','Literal','Nrelacionadas','Clase','Reqlegal','Esperada','Fecha','Prox','Area','Cumplimiento','frecuencia','Calif');
          

 
           $path ='../storage/plantillas_excel/'.$empresas[$id].'.xlsx';
           //return $path;
            if(file_exists($path))
            { 
              Excel::load('storage/plantillas_excel/'.$empresas[$id].'.xlsx',function($sheet)use($export,$tipo,$id,$order){ 
              if ($tipo==1)
              {
                $sheet->setActiveSheetIndex(0)->setCellValue('E9', 'EMERGENCIAS');  
              } 
              elseif($tipo==2)               
              {
                $sheet->setActiveSheetIndex(0)->setCellValue('E9', 'SEGURIDAD Y SALUD EN EL TRABAJO');  
              }
              elseif($tipo==3)
              {
               $sheet->setActiveSheetIndex(0)->setCellValue('E9', 'AMBIENTAL'); 
              }
               

              $last_date = Requisitos::Where('id_empresa','=',$id)->orderBy('id','desc')->first(); 

              $sheet->setActiveSheetIndex(0)->setCellValue('D14', $last_date->created_at->format('d/m/Y'));

              $row = 23;
         
              $clases = ClaseNorma::lists('nombre','id');  

                  foreach($export as $key => $temp) 
                 {

                      $col = 0;                  
                      
                      //$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $key+1);              
                           
                      foreach($order as $value)
                      {                         
                              
                          //echo var_dump($temp);
                            if($value == 'frecuencia')
                            {
                              //$frecuencia = Externclass::frecuencia_evaluacion($temp['Fecha'],$temp['fechaprox']);
                              $date = floor(strtotime($temp->Fecha)/(60*60*24));
                              $date2 = floor(strtotime($temp->Prox)/(60*60*24));
                              if ($date != null)
                              {
                                  $oper = $date2-$date;
                                  switch (true)
                                  {
                                    case ($oper>0&&$oper<=45):
                                    $oper = 'mensual';
                                    break;
                                    case ($oper>45&&$oper<=90):
                                    $oper = 'trimestral';
                                    break;
                                    case ($oper>90&&$oper<=180):
                                    $oper = 'semestral';
                                    break;
                                    case ($oper>180&&$oper<=400):
                                    $oper = 'anual';
                                    break;
                                    default:
                                    $oper = ' ';
                                  }  
                              }
                              else {
                                $oper = ' ';
                              }                              
                             
                              $sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $oper);
                               
                            }  
                            elseif($value == 'clase_norma_id')
                            {
                              $i=0;
                              if($temp['Estado']=='Derogado'){

                                $sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Derogada');
                              }
                              else { 
                                $sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $clases[$temp[$value]]);
                               }
                            }                      
                             
                            else
                            {
                              $sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $temp->$value);
                                
                            }                          
                          $col++;
                      }
                      $row++;
                  }          

              })->export('xlsx');
    
            }
            else{
              return 'No existe formato para descarga de archivos , comuniquese con el administrador .';
            } 
      }
   

    public function exportar2($id,$tipo)
    {
        $query = "select Fecha = (select MAX(Evaluacion.fecha)  from Evaluacion LEFT JOIN Requisitos on Evaluacion.id_Requisitos = Requisitos.id where Requisitos.id = r.id ) as conditioner, r.id as id ,tm.nombre as Tipo, f.nombre as Factor , c.nombre as Categoria, tp.nombre as Tpnorma , au.nombre as Autoridad , y.`year` as Emision , n.numero as Numero , a.numero as Articulo , es.nombre as Estado, l.numero as Literal , n.descripcion as Descnorma , r.nrelacionadas as Nrelacionadas ,r.reqlegal as Reqlegal , r.esperada as Esperada , r.area as Area , r.responsable as Cargo , cl.nombre as Clase , eval.fecha as Fecha , eval.cumplimiento as Cumplimiento , eval.Calificacion as Calif , eval.fecha_prox as Prox, cl.id as cl_id, es.id as es_id from Requisitos as r inner JOIN empresa as e on r.id_empresa = e.idempresa INNER JOIN Categorias as c on c.id = r.id_Categorias INNER JOIN Factores as f on f.id = c.id_Factores INNER JOIN Tipo_matriz as tm on tm.id = f.id_Tipo_matriz INNER JOIN Articulos as a on a.id = r.id_Articulos INNER JOIN Normas as n on n.id = a.id_Normas  INNER JOIN Tipo_norma as tp on tp.id=n.id_Tipo_norma INNER JOIN Autoridad_emisora as au on au.id = n.id_Autoridad_emisora INNER JOIN Emision as y on y.id = n.id_Emision INNER JOIN Clase_norma as cl on cl.id = r.id_Clase_norma INNER JOIN Estados_vigencia as es on es.id = a.id_Estados_vigencia  LEFT JOIN Literales as l on l.id = r.id_Literales LEFT JOIN Evaluacion as eval on eval.id_Requisitos = r.id  where r.id_empresa= ".$id." and tm.id = ".$tipo."  and r.deleted_at is null having conditioner = 1 or conditioner is null ORDER BY id ";

        //echo $query;

        //exit;

        $requisitos = DB::select(DB::raw($query)); 

      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-Disposition: attachment; filename=descarga_formato_subida.xls");  //File name extension was wrong
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Cache-Control: private",false);      
      echo view('general.formato_subida',compact('requisitos'));
    } 

    public function layout()
    {
      $empresas=Empresa::lists('nombre','idempresa');
      return view('empresa.plantilla',compact('empresas'));
    }

    public function delete_layout($file)
    {
      if(file_exists(storage_path('plantillas_excel/'.$file.'.xlsx')))
      {
        Storage::disk('plantillas_excel')->delete($file.'.xlsx');
        return redirect('/Layouts')->with('message','erased');
      }

      else {
            return "no existe el documento";
        }  
    }

    public function download_layout($file)
    {
      if(file_exists(storage_path('plantillas_excel/'.$file.'.xlsx')))
        {
            $file_path = storage_path('plantillas_excel/'.$file.'.xlsx');
            return response()->download($file_path);
        
        }

        else {
            return "no existe el documento";
        }  
    }

    public function save_layout(Request $request)
    {      
      $name= $request->empresa.'.xlsx';
      if(file_exists(storage_path('plantillas_excel/'.$name)))
      {
        return redirect('/Layouts')->with('message','repeated');
      }         
      $archivo = $request->file('archivo');
      $upload=Storage::disk('plantillas_excel')->put($name,  \File::get($archivo));
      return redirect('/Layouts')->with('message','store');
    }

  public function sectorIndustria()
  {
     $sectores = Sector::lists('sector','idsector');
     $industrias = Industria::paginate(30);
     $sectors = Sector::paginate(30);  
    
     return view('empresa.sectoryindustria',compact('sectores','industrias','sectors'));
  } 

  public function formSector()
  {
    return view('empresa.createSector');
  } 

  public function createSector(Request $request)
  {
    $id=Sector::lists('idsector')->last();
    $validation = Validation::check_create_repeat(new Sector(),$request->sector,'sector');
    if($validation!='deny')
    {   
      Sector::create(['idsector'=>$id+1,'sector'=>$request->sector]);
      return redirect('SectorIndustria')->with('message','store1');
    }
    else
    {
     return redirect('SectorIndustria')->with('message','deny'); 
    }  
  }

  public function Sectoredit($id)
  {
    $sector = Sector::find($id);
    return view('empresa.editSector',compact('id','sector'));
  }

  public function updateSector(Request $request , $id)
  {
    $sector = Sector::find($id);
    $validation = Validation::check_update_repeat($request->sector,new Sector(),'sector','idsector',$id);
    if($validation!='deny')
    {  
     $sector->fill(['sector'=>$request->sector]);
     return redirect('SectorIndustria')->with('message','update');
    }
    else
    {
      return redirect('SectorIndustria')->with('message','deny');
    }  

  }

  public function deleteSector($id)
  { 
    $sector = Sector::find($id);    
    $sector->delete();
    return redirect('SectorIndustria')->with('message','deleted');
  }

   public function formIndustria()
  {
    $sector = Sector::lists('sector','idsector');
    return view('empresa.createIndustria',compact('sector'));
  }

  public function createIndustria(Request $request)
  {
    $id=Industria::lists('idindustria')->last();
    $validation = Validation::check_create_twoparams(new Industria(),'sector_id','industria',$request->sector,$request->industria);
    if($validation!='deny')
    {   
      Industria::create(['idindustria'=>$id+1,'industria'=>$request->industria,'sector_id'=>$request->sector]);
      return redirect('SectorIndustria')->with('message','store2');
    }
    else
    {
     return redirect('SectorIndustria')->with('message','deny'); 
    }
  }

    public function IndustriaEdit($id)
  {   
    $sector = Sector::lists('sector','idsector');
    $industria = Industria::find($id);
    return view('empresa.editIndustria',compact('id','sector','industria'));
  }

  public function updateIndustria(Request $request , $id)
  {
    //return "bitches";
    $industria = industria::find($id);
    $validation = Validation::check_update_twoparams(new industria(),'industria','sector_id','idindustria',$request->industria,$request->sector,$id);   
    if($validation!='deny')
    {  
     $industria->fill(['industria'=>$request->industria,'sector_id'=>$request->sector]);
     return redirect('SectorIndustria')->with('message','update');
    }
    else
    {
      return redirect('SectorIndustria')->with('message','deny');
    }  

  }

    public function deleteIndustria($id)
  {
    $industria = Industria::find($id);
    $industria -> delete();
    return redirect('SectorIndustria')->with('message','deleted');
  }

  public function tabla_sectores()
  {
      $sectores = Sector::lists('sector','idsector');
     $industrias = Industria::paginate(30);
     $sectors = Sector::paginate(30);  
    return view('empresa.forms.sectores_tabla',compact('sectores','industrias','sectors'));
  }

  public function tabla_industrias()
  {
      $sectores = Sector::lists('sector','idsector');
      $industrias = Industria::paginate(30);
      $sectors = Sector::paginate(30);  
      return view('empresa.forms.industrias_tabla',compact('sectores','industrias','sectors'));
  }

  public function users_by_enterprise(Request $request)
  {
      $enterprise_id = $request->enterprise_id;
      /*$query = 'select * from usuarios where EmpresasPermiso in (select idempresa from empresa where nombre like  "%'.$enterprise_name.'%" ) ';*/
      $query = 'select * from usuarios where EmpresasPermiso like "%'.$enterprise_id.'%" and estado in (0,1)';
      //return $query;
      $users = DB::select(DB::raw($query));
      //print_r($users);
      //return "";
      $current_action = Session::get('current_action');
      //print_r($current_action);
      //exit;
      $get_selected_values = $current_action::Where('empresa','=',$enterprise_id)->value('usuarios');
      $users_array = explode(",", $get_selected_values);
      return view('empresa.subviews.users_by_enterprise',compact('users','enterprise_id','users_array'));
  }

}