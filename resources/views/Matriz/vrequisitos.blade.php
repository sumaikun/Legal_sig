
@extends('layouts.layout2')

  @section('content')
    {!!Html::style('css/editable_table_style.css')!!}

  {!!Html::script('js/editable_table/Source.js')!!}
  
      <?php $message=Session::get('message')?>


    @if($message == 'evaluated')
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Requisitos Evaluados</strong>  
    </div>
    @endif
  

    @if($message == 'stored')
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Requisito Creado</strong>  
    </div>
    @endif

    @if($message == 'repeated')
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Ya existe un requisito igual</strong>  
    </div>
    @endif

    @if($message == 'updated')
    <div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Requisito actualizado</strong>  
    </div>
    @endif

   @if($message == 'deleted')
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Requisito eliminado</strong>  
    </div>
    @endif

    @if($message == 'passed')
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Requisitos trasladados</strong>  
    </div>
    @endif

    @if($message == 'commented')
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Comentario realizado</strong>  
    </div>
    @endif

   @if($message == 'erasedall')
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Validaciones eliminadas</strong>  
    </div>
   @endif

    @if($message == 'no_allowed_der')
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Uno de los articulos de los requisitos a evaluar esta derogado, vuelva a intentarlo</strong>  
    </div>
   @endif          

    <div class="container-fluid">
  <h1>Matriz de requisitos legales</h1>
   <div class = "load col-lg-12" style= "max-height:0px; margin-top: -45px;" >
   </div>
      <div class="form-group col-lg-12">
            {!!Form::label('Empresa')!!}
            {!!Form::select('empresa',$empresas,null,['id'=>'empresa','class'=>'form-control','placeholder'=>'Selecciona'])!!}
        </div>
        <div class="form-group col-lg-2">
            {!!Form::label('Tipo_Matriz')!!}
            <select id="tipo_matriz" class="form-control form-filters" disabled>
              <option value="placeholder">Selecciona</option>
              @foreach($tiposmatriz as $key=>$value)
              <option value="{{$key}}">{{$value}}</option>
              @endforeach
            </select>
         </div>
        <div class="form-group col-lg-2">
            {!!Form::label('Factores')!!}
            <select id="factores" class="form-control form-filters" disabled>
              <option value="placeholder">Selecciona</option>
            </select>
         </div>     
        <div class="form-group col-lg-2">
            {!!Form::label('Categorías')!!}
            <select id="categorias" class="form-control form-filters" disabled>
              <option value="placeholder">Selecciona</option>
            </select>   
        </div>
        <div class="form-group col-lg-2" >
            {!!Form::label('Tipo norma')!!}
            <select id="tipo_norma" class="form-control form-filters" disabled>
              <option value="placeholder">Selecciona</option>
              @foreach($tiposnorma as $tiponorma)
              <option value="{{$tiponorma->id}}">{{$tiponorma->nombre}}</option>
              @endforeach
            </select>
        </div>
        <div class="form-group col-lg-2"  >
            {!!Form::label('Norma Número')!!}
              <select id="norma" class="form-control form-filters" disabled>
              <option value="placeholder">Selecciona</option>              
            </select>
        </div>      
        <div class="form-group col-lg-2" >
            {!!Form::label('Año de Emisión')!!}
            <select id="year" class="form-control form-filters" disabled>
              <option value="placeholder">Selecciona</option>
              @foreach($years as $year)
              <option value="{{$year->id}}">{{$year->year}}</option>
              @endforeach
            </select>
        </div>
        <div class="form-group col-lg-2" >
            {!!Form::label('Artículos')!!}
            <select id="articulos" class="form-control form-filters" disabled>
              <option value="placeholder">Selecciona</option>              
            </select>
        </div>          
        <div class="form-group col-lg-2 " >
            {!!Form::label('Autoridad que Emite')!!}
            <select id="autoridad_emisora" class="form-control form-filters" disabled>
              <option value="placeholder">Selecciona</option>
              @foreach($autoridades as $autoridad)
              <option value="{{$autoridad->id}}">{{$autoridad->nombre}}</option>
              @endforeach
            </select>
         </div>
         <div class="form-group col-lg-2 " >
            {!!Form::label('Actualizaciones')!!}
            <select id="versiones" class="form-control form-filters" disabled>
              <option value="placeholder">Selecciona</option>             
            </select>
         </div>
         <div class="form-group col-lg-2 " >
            {!!Form::label('Estado de los requisitos')!!}
            <select id="estado_requisitos" class="form-control form-filters" disabled>
              <option value="placeholder">Selecciona</option>
              <option value="1">Sin vencer</option>
              <option value="2">Vencidos</option>             
            </select>
         </div>



        <div class="col-lg-6"></div>

<div class="col-lg-12">
  @if(Auth::user()->rol_id != 3)
    <!--<p>Bienvenidos a <strong>Matriz de requisitos legales</strong> por favor reporte cualquier error por  <a href="#">AQUI</a></p> -->
     <button class="btn btn-primary form-button" data-toggle="modal" data-target="#myModal3" onclick="create_req()" title="crear nuevo" disabled><span class="glyphicon glyphicon-plus"></span> Nuevo requisito</button>
     <button class="btn btn-warning form-button btn_one_req" onclick="evaluate_reqs()" title="evaluar" disabled><span class="glyphicon glyphicon-pencil"></span> Evaluar</button>

  @endif
  <button class="btn btn-success form-button btn_one_req"  data-toggle="modal" data-target="#modalexcel" title="Descargar Excel" disabled><span class="glyphicon glyphicon-menu-down"></span> Excel </button>

</div>

<div class="col-lg-12" style="margin-top: 15px;">  
  <div id="table" class="table-editable">
    
      <div id="ajax-content"> 
        <table id="example"  style="font-size: 75%;" class="table">
      <thead>
       <tr>
              <th>Id </th>              
              <th>Grupo/Tema</th>
              <th>Factor Riesgo </th>
              <th>Categoria </th>             
              <th> Tipo de<br> Norma </th> 
              <th> Número </th> 
              <th> Año <br>Emision </th>                        
              <th> Autoridad <br>Emisora </th> 
              <th style="max-width:50px;"> Artículos </th> 
              <th> Estado<br>Articulo</th>
              <th style="max-width:60px;"> Literal </th>                       
              <th></th>
          </tr>
      </thead>
          <tbody>
          <tr><!--
            <td contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)">Con position:absolute el objeto tomara como referencia a un objeto de posición estatica para poder modificar su posición.
    Con position relative se comporta como un static pero que se le pueden agregar unos valores extra para modificarlo.
    Con el position fixed un elemento se queda fijo en la pantalla y puede desplazarse a través de otros objetos.
    </td>-->
            <td>Id</td>            
              <td> Grupo/Tema </td>
              <td>Factor Riesgo </td>
              <td>Categoria </td>            
              <td> Tipo de Norma </td> 
              <td> Número </td> 
              <td> Año de emisión </td>                        
              <td> Autoridad E. </td> 
              <td> ArtÍculos </td> 
              <td> Estado Art.</td>
              <td> Literal </td>                          
              <td></td>

          </tr>      
        </tbody>
        <tfoot>
       <tr>
              <th>Id </th>              
              <th>Grupo/Tema</th>
              <th>Factor Riesgo </th>
              <th>Categoria </th>               
              <th> Tipo de<br> Norma </th> 
              <th> Número </th> 
              <th> Año <br>Emision </th>                        
              <th> Autoridad <br>Emisora </th> 
              <th style="max-width:50px;"> Artículos </th> 
              <th> Estado<br>Articulo</th>
              <th style="max-width:60px;"> Literal </th>                    
              <th></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  

  
  <p id="export"></p>        

</div>
</div>


<div class="modal fade" id="modalpassdata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>Pasar datos
            </h4>
            <a href="{{route('delete_no_valid')}}"><button>Eliminar datos</button></a>
         </div>
         <div class="modal-body">              
            <div class="row">  
              <div class="col-lg-12">
                <div class="form-group col-lg-12">
                  {!!Form::label('Empresa')!!}
                   {!!Form::select('empresa',$empresas,null,['id'=>'passdata','class'=>'form-control','placeholder'=>'Selecciona'])!!}
                </div>
              </div>
            </div>      
         </div>
         <div class="modal-footer">
            <button type="button" id="literal_cancel_new"  class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" id="make_passdata"   class="btn btn-success"><i class="fa fa-floppy-o"></i>Pasar datos</button>
         </div>
      </div>
   </div>
</div>



<!-- Modal -->
<div id="modalexcel" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tipo de matriz</h4>
      </div>
      <div class="modal-body">      
          {!!Form::label('Tipo_Matriz')!!}
          <select name="download_tpmatriz" class="form-control">
            <option value="placeholder">Selecciona</option>
            @foreach($tiposmatriz as $key=>$value)
            <option value="{{$key}}">{{$value}}</option>
            @endforeach
          </select>                  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  onclick="download_excel()" data-dismiss="modal">Descargar</button>
        @if(Auth::user()->rol_id!=3)
        <button type="button" class="btn btn-default"  onclick="download_excel2()" data-dismiss="modal">Descargar<br> Formato de subida</button>
        @endif
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>  

@include('Matriz.subviews.requisitosmodals')

{!!Html::script('js/editable_table/Resize.js')!!}
<script>
  $("#make_passdata").click(function(){
    if($("#passdata").val()!="")     
      {window.location.href = 'passdata/'+$("#passdata").val();}
    else {
      alert("debes seleccionar una empresa");
    }   
  });

  function evaluate_reqs(){
    var checkedBoxes = getCheckedBoxes();
    checkedBoxes != null ? $("#modalevaluation").modal('show') : alert('selecciona algun requisito para evaluar');
    checkedBoxes != null ? $("#reqs_to_eval").val(checkedBoxes.toString()): "";    
    console.log(checkedBoxes);
  }

  var checkboxesChecked = [];

  function insert_requirement(element)
  {
    if ($(element).is(':checked')){
      if(checkboxesChecked.indexOf(element.value))
      {
        checkboxesChecked.push(element.value);  
      }      
      console.log(checkboxesChecked);
    }
    else
    {
      //console.log("posición "+checkboxesChecked.indexOf(element.value));
      if(checkboxesChecked.indexOf(element.value)>=-1)
      {
        
        checkboxesChecked.splice(checkboxesChecked.indexOf(element.value), 1);
           
      }
      console.log(checkboxesChecked);
    }
  }

  function getCheckedBoxes() {    
    return checkboxesChecked.length > 0 ? checkboxesChecked : null;
  }

</script>

<script>
 $(document).ready(function(){
    $('#example').DataTable({
       "bSort": true,
       "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
       },
       fixedHeader: {
            header: true
        },"pageLength": 50
      });
  });



function big_text_edit(elem){
  var id = $(elem).css("white-space","normal");
   
}

function big_text_edit_over(elem){
  console.log("sali");
  var id = $(elem).css("white-space","nowrap");
   
}

//Ajax function

  $(document).ready(function() {
      $("#empresa").change(event => {
        
        if($("#empresa").val()!='')
        {
          reset_elements();
          tp_autoridad($("#empresa").val());
          $('input[name=infoempresa]').val($("#empresa").val());//para agregarle un valor al hidden del form
          var load = "<div class='loader'><span></span><span></span> <span></span></div>";
          $(".load").append(load) ;
          $.get(`management_filterenterprise`+`/${event.target.value}`, function(res){
              $('#ajax-content').empty();               
              $('#ajax-content').html(res);
              $(".load").empty();
              table = $('#example').DataTable({"bSort": true,
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
              },
               fixedHeader: {
                    header: true
                },"pageLength": 50});
              console.log(table.data().count());
            });
          $.get(`get_versions`+`/${event.target.value}`, function(res){
              $("#versiones").empty();
              $("#versiones").append(`<option value="placeholder">Selecciona</option>`);
              res.forEach(element => {
                $("#versiones").append(`<option value=${element.fecha}> ${element.fecha} </option>`);
              });
            });

            disable_elements(1);
      }
      else{disable_elements(0); }       
        });

      $("#tipo_matriz").change(event => {        
        if($("#tipo_matriz").val()!='')
        {          
          $.get(`filterfactoreswithemp`+`/${event.target.value}/`+$("#empresa").val(), function(res){
              $("#factores").empty();
              $("#factores").append(`<option value="placeholder">Selecciona</option>`);
              res.forEach(element => {
                $("#factores").append(`<option value=${element.id}> ${element.nombre} </option>`);
              });
            });       
          }      
        });
      $("#factores").change(event => {        
        if($("#factores").val()!='')
        {          
          $.get(`filtercategoriaswithemp`+`/${event.target.value}/`+$("#empresa").val(), function(res){
              $("#categorias").empty();
              $("#categorias").append(`<option value="placeholder">Selecciona</option>`);
              res.forEach(element => {
                $("#categorias").append(`<option value=${element.id}> ${element.nombre} </option>`);
              });
            });       
          }      
        });
      $("#tipo_norma").change(event => {        
        if($("#tipo_norma").val()!='')
        {          
          $.get(`filternormaswithemp`+`/${event.target.value}/`+$("#empresa").val(), function(res){              
              $("#norma").empty();
              $("#norma").append(`<option value="">Selecciona</option>`);
              res.forEach(element => {
                $("#norma").append(`<option value=${element.id}> ${element.numero} </option>`);
              });
            });       
          }      
        });
      $("#norma").change(event => {        
        if($("#norma").val()!='')
        {          
          $.get(`filterarticuloswithemp`+`/${event.target.value}/`+$("#empresa").val(), function(res){              
              $("#articulos").empty();
              $("#articulos").append(`<option value="">Selecciona</option>`);
              res.forEach(element => {
                $("#articulos").append(`<option value=${element.id}> ${element.numero} </option>`);
              });
            });       
          }      
        });
    });

  function tp_autoridad()
  {
    $.get(`filtertpswithemp/`+$("#empresa").val(), function(res){              
        $("#tipo_norma").empty();
        $("#tipo_norma").append(`<option value="">Selecciona</option>`);
        res.forEach(element => {
          $("#tipo_norma").append(`<option value=${element.id}> ${element.nombre} </option>`);
        });
      });

    $.get(`filteraeswithemp/`+$("#empresa").val(), function(res){              
        $("#autoridad_emisora").empty();
        $("#autoridad_emisora").append(`<option value="">Selecciona</option>`);
        res.forEach(element => {
          $("#autoridad_emisora").append(`<option value=${element.id}> ${element.nombre} </option>`);
        });
      });
  }

//disable select fields


    function disable_elements(cond){
      if(cond == 1)
      {$( ".form-control" ).prop( "disabled", false );$( ".form-button" ).prop( "disabled", false );}
      else{
        $( ".form-control" ).prop( "disabled", true );
        $( ".form-button" ).prop( "disabled", true );
        $("#empresa").prop( "disabled", false );
        $('.load').empty();
      }
      
    }

    function reset_elements()
    {
      $( ".form-filters" ).val("placeholder");
    }

    

    $(document).ready(function() {
      $(".form-filters").change(event => {
          if($("#tipo_matriz").val()=="")
          {
            tipo_matriz = 'placeholder';
          }
          else{
            tipo_matriz = $("#tipo_matriz").val(); 
          }
          if($("#factores").val()=="")
          {
            factores = 'placeholder';
          }
          else{
            factores = $("#factores").val(); 
          }
          if($("#categorias").val()=="")
          {
            categorias = 'placeholder';
          }
          else{
            categorias = $("#categorias").val(); 
          }
          if($("#tipo_norma").val()=="")
          {
            tipo_norma = 'placeholder';
          }
          else{
            tipo_norma = $("#tipo_norma").val(); 
          }
          if($("#norma").val()=="")
          {
            norma = 'placeholder';
          }
          else{
            norma = $("#norma").val(); 
          }
          if($("#year").val()=="")
          {
            year = 'placeholder';
          }
          else{
            year = $("#year").val(); 
          }
          if($("#articulos").val()=="")
          {
            articulos = 'placeholder';
          }
          else{
            articulos = $("#articulos").val(); 
          }         
          if($("#autoridad_emisora").val()=="")
          {
            autoridad_emisora = 'placeholder';
          }
          else{
            autoridad_emisora = $("#autoridad_emisora").val(); 
          }
                       
          var load = "<div class='loader'><span></span><span></span> <span></span></div>";
          $(".load").append(load) ;
          $.get('management_other_filters/'+$("#empresa").val()+"/"+tipo_matriz+"/"+factores+"/"+categorias+"/"+tipo_norma+"/"+norma+"/"+year+"/"+articulos+"/"+autoridad_emisora+"/"+$('#versiones').val()+"/"+$('#estado_requisitos').val(), function(res){

            $(".load").empty();     
              $('#ajax-content').empty();
              $('#ajax-content').html(res);
               var table = $('#example').DataTable({"bSort": true,
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
              },
               fixedHeader: {
                    header: true
                },"pageLength": 50});
               console.log(table.data().count());
            });       
        });
    });

    function addcumplimiento(nrelacionada,reqlegal,clase,evidencia,responsable,area,id){
      /*console.log('existo'+nrelacionada);
      console.log('existo'+reqlegal);
      console.log('existo'+clase);
      console.log('existo'+evidencia);
      console.log('existo'+responsable);
      console.log('existo'+area);
      console.log('existo'+id);*/
      $("#relacionada").empty();
      $("#reqlegal").empty();
      $("#clase").empty();
      $("#evidencia").empty();
      $("#responsable").empty();
      $("#area").empty();
      $("#cump_id").val(id);
      $("#relacionada").append(nrelacionada);
      $("#reqlegal").append(reqlegal);
      $("#clase").append(clase);
      $("#evidencia").append(evidencia);
      $("#responsable").append(responsable);
      $("#area").append(area);

    }

    /*function addevaluacion(fecha,evidenciacump,calificacion,fechaprox,id){
      console.log('existo');
      $("#fecha").empty();
      $("#cumpevidencia").empty();
      $("#calif").empty();
      $("#proxfecha").empty();
      //console.log("prueba"+evidenciacump);      

      $("#fecha").append(fecha);
      $("#cumpevidencia").append(evidenciacump);
      $("#calif").append(calificacion);
      $("#proxfecha").append(fechaprox);

      $("#eval_table_ajax").empty();
      $(".idreq").val(id);
    }*/


    function addevaluacion(id){
      //console.log('existo');
      $.get(`evalinfo`+`/`+id, function(res){
        $("#fecha").empty();
        $("#cumpevidencia").empty();
        $("#calif").empty();
        $("#proxfecha").empty();
          
        $("#fecha").append(res.fecha);
        $("#cumpevidencia").append(res.cumplimiento);
        $("#calif").append(res.Calificacion);
        $("#proxfecha").append(res.fecha_prox);

        $("#eval_table_ajax").empty();
        $(".idreq").val(id);
        console.log(res);
      });
      
    }

    function addfactores(element){
      if($(element).val()!="")
      {
        $.get('filterfactores/'+$(element).val(), function(res){
          $("#form1_factores").empty();
          $("#form1_factores").append(`<option value="">Selecciona</option>`);              
          res.forEach(element => {
            $("#form1_factores").append(`<option value=${element.id}> ${element.nombre} </option>`);
          });
          $("#form1_factores").append(`<option value="new">+ NUEVO FACTOR</option>`);
        }); 
      }
      return 'finish';
    }  

    function addcategorias(element){
      if($(element).val()!="")
      {
        $.get(`filtercategorias/`+$(element).val(), function(res){
          $("#form1_categorias").empty();
          $("#form1_categorias").append(`<option value="">Selecciona</option>`);
          res.forEach(element => {
            $("#form1_categorias").append(`<option value=${element.id}> ${element.nombre} </option>`);
          });
          $("#form1_categorias").append(`<option value="new">+ NUEVA CATEGORIA</option>`);
        }); 
      }   
    }

    function addnormas(element){
      if($(element).val()!="")
      {
       $.get(`filternormas/`+$(element).val(), function(res){              
          $("#form1_norma").empty();
          $("#form1_norma").append(`<option value="">Selecciona</option>`);          
            res.forEach(element => {
            $("#form1_norma").append(`<option value=${element.id}> ${element.numero} </option>`);
          });
            $("#form1_norma").append(`<option value="new">+ NUEVA NORMA</option>`);
        });   
      }  
    }

    function addnorma_data(element)
    {
      addarticulos(element);
      addautoridad(element);
      addyear(element);
    }

    function addarticulos(element)
    {
      if($(element).val()!="")
      {
        $.get(`filterarticulos/`+$(element).val(), function(res){              
          $("#form1_articulos").empty();
          $("#form1_articulos").append(`<option value="">Selecciona</option>`);  
              res.forEach(element => {
              $("#form1_articulos").append(`<option value=${element.id}> ${element.numero} </option>`);
          });
             $("#form1_articulos").append(`<option value="new">+ NUEVO ARTICULO</option>`); 
        });
      }  
    }

    function addautoridad(element)
    {
      if($(element).val()!="")
      {
        $.get(`filterautoridad/`+$(element).val(), function(res){              
          $("#fm_autoridad").empty();
          $("#fm_autoridad").append(`<option value="">Selecciona</option>`);  
              res.forEach(element => {
                $("#fm_autoridad").append(`<option value=${element.id} selected> ${element.nombre} </option>`);
          });
              //$("#form1_autoridad" ).prop( "disabled", true );
        });
      }  
    }

    function addyear(element)
    {
      if($(element).val()!="")
      {
        $("#fm_year").empty();
        $("#fm_year").append(`<option value="">Selecciona</option>`);          
        $.get(`filteryear/`+$(element).val(), function(res){              
              res.forEach(element => {
                $("#fm_year").append(`<option value=${element.id} selected> ${element.year} </option>`);
          });
              //$("#form1_year" ).prop( "disabled", true );
        });
      }  
    }

    function addliterales(element)
    {
      if($(element).val()!="")
      {
        $("#form1_literales").empty();
        $("#form1_literales").append(`<option value="">Selecciona</option>`);       
        $.get(`filterliteral/`+$(element).val(), function(res){              
              res.forEach(element => {
                $("#form1_literales").append(`<option value=${element.id} selected> ${element.numero} </option>`);
          });
          $("#form1_literales").append(`<option value="new">+ NUEVO LITERAL</option>`);              
        });
      } 
    }

    function requisito_edit(id)
    {
      document.getElementById("form1").action = "update_requisito/"+id;
      $("#myModal3").modal('show');
      $("#reqproccess_title").empty();
      $("#reqproccess_title").append("Editar requisito");
      $.get(`edit_requisito/`+id, function(res){
          var firstres= res;
           $("select[name='tpmatriz']").val(res[0].tipom);                                      
            $("textarea[name='reqlegal']").append(res[0].reqlegal);
            $("input[name='responsable']").val(res[0].responsable);
            $("textarea[name='esperada']").append(res[0].esperada);
            $("input[name='area']").val(res[0].area);
            $("select[name='clase']").val(res[0].clase);            
            $.get('filterfactores/'+res[0].tipom, function(res){              
              $("#form1_factores").empty();
              $("#form1_factores").append(`<option value="">Selecciona</option>`);              
              res.forEach(element => {
              $("#form1_factores").append(`<option value=${element.id}> ${element.nombre} </option>`);
              });
              $("#form1_factores").append(`<option value="new">+ NUEVO FACTOR</option>`);
              $("#form1_factores").val(firstres[0].factor);
            });
            $.get(`filtercategorias/`+res[0].factor, function(res){
              $("#form1_categorias").empty();
              $("#form1_categorias").append(`<option value="">Selecciona</option>`);
              res.forEach(element => {
              $("#form1_categorias").append(`<option value=${element.id}> ${element.nombre} </option>`);
              });
              $("#form1_categorias").append(`<option value="new">+ NUEVA CATEGORIA</option>`);
              $("#form1_categorias").val(firstres[0].categoria);
            });
            $("select[name='tp_norma']").val(res[0].tipon);
            $.get(`filtercategorias/`+res[0].factor, function(res){
              $("#form1_categorias").empty();
              $("#form1_categorias").append(`<option value="">Selecciona</option>`);
              res.forEach(element => {
              $("#form1_categorias").append(`<option value=${element.id}> ${element.nombre} </option>`);
              });
              $("#form1_categorias").append(`<option value="new">+ NUEVA CATEGORIA</option>`);
              $("#form1_categorias").val(firstres[0].categoria);
            });
            $.get(`filternormas/`+res[0].tipon, function(res){              
              $("#form1_norma").empty();
              $("#form1_norma").append(`<option value="">Selecciona</option>`);          
                res.forEach(element => {
                $("#form1_norma").append(`<option value=${element.id}> ${element.numero} </option>`);
              });
                $("#form1_norma").append(`<option value="new">+ NUEVA NORMA</option>`);
                $("#form1_norma").val(firstres[0].norma);
            });
            $.get(`filterautoridad/`+res[0].norma, function(res){              
              $("#fm_autoridad").empty();
              $("#fm_autoridad").append(`<option value="">Selecciona</option>`);  
                  res.forEach(element => {
                    $("#fm_autoridad").append(`<option value=${element.id} selected> ${element.nombre} </option>`);
              });
                  //$("#form1_autoridad" ).prop( "disabled", true );
            });
            $("#fm_year").empty();
            $("#fm_year").append(`<option value="">Selecciona</option>`);          
            $.get(`filteryear/`+res[0].norma, function(res){              
                  res.forEach(element => {
                    $("#fm_year").append(`<option value=${element.id} selected> ${element.year} </option>`);
              });
                  //$("#form1_year" ).prop( "disabled", true );
            });
            $.get(`filterarticulos/`+res[0].norma, function(res){              
              $("#form1_articulos").empty();
              $("#form1_articulos").append(`<option value="">Selecciona</option>`);  
                  res.forEach(element => {
                  $("#form1_articulos").append(`<option value=${element.id}> ${element.numero} </option>`);
              });
              $("#form1_articulos").append(`<option value="new">+ NUEVO ARTICULO</option>`);
              $("#form1_articulos").val(firstres[0].articulo); 
            });                  
            $.get(`filterliteral/`+res[0].articulo, function(res){              
              $("#form1_literales").empty();
              $("#form1_literales").append(`<option value="">Selecciona</option>`);
              res.forEach(element => {
                $("#form1_literales").append(`<option value=${element.id} selected> ${element.numero} </option>`);
              });
              $("#form1_literales").append(`<option value="new">+ NUEVO LITERAL</option>`);
              $("#form1_literales").val(firstres[0].literal);              
            });    
        });      
    }

    function create_req()
    {
      $("#reqproccess_title").empty();
      $("#reqproccess_title").append("Crear requisito");
      document.getElementById("form1").action = "create_requisito";
      $('#form1').trigger("reset");
      $("textarea[name='reqlegal']").empty();
      $("textarea[name='esperada']").empty();
    }

    function download_excel()
    {
      window.location.href = 'download_excel/'+$("input[name='infoempresa']").val()+"/"+$("select[name='download_tpmatriz']").val();
    }

    function download_excel2()
    {
      window.location.href = 'download_excel2/'+$("input[name='infoempresa']").val()+"/"+$("select[name='download_tpmatriz']").val();
    }

</script>



 
      
@stop 