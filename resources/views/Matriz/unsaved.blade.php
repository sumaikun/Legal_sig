@extends('layouts.layout2')
  @section('content')

  {!!Html::style('css/editable_table_style.css')!!}

  {!!Html::script('js/editable_table/Source.js')!!}
  
  <?php $message=Session::get('message')?>

  @if($message == 'passed')
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Requisitos trasladados</strong>  
    </div>
  @endif

  @if($message == 'erasedall')
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Validaciones eliminadas</strong>  
    </div>
  @endif 

  <div class="container-fluid">
    <h1>Registros a arreglar</h1>
         <div class="form-group col-lg-12" id="thfilters2">
            {!!Form::label('Empresa')!!}
            {!!Form::select('empresa',$empresas,null,['id'=>'empresa','class'=>'form-control','placeholder'=>'Selecciona'])!!}
        </div>
    <div class="col-lg-12">
      @if(Auth::user()->rol_id==1)  
      <button class="btn btn-warning form-button btn_one_req" onclick="pass_data()" title="Pasar datos"><span class="glyphicon glyphicon-pencil"></span> Pasar datos de validaciones</button>
      @endif
    </div>

    <div class="col-lg-12" style="margin-top: 15px;">

      <div id="table" class="table-editable">
      
    
          <div id="ajax-content"> 
        <table id="example"  style="font-size: 75%;" class="table">
          <thead>
           <tr>
                  <th>Tipo</th>
                  <th>Empresas</th>                  
                  <th>Tipo Norma</th>
                  <th>Emisión</th>                                   
                  <th>norma</th> 
                  <th>articulo</th> 
                  <th>Descripcion</th>                        
                  <th>Fecha</th>
                  <th>btn</th>                  
              </tr>
          </thead>
              <tbody>
                  <td>Tipo</td>
                  <td>Empresas</td>                  
                  <td>Tipo Norma</td>
                  <td>Emisión</td>                                   
                  <td>norma</td> 
                  <td>articulo</td> 
                  <td>Descripcion</td>                        
                  <td>Fecha</td>
                  <td>btn</td> 
            </tbody>
            <tfoot>
            <tr>
                  <th>Tipo</th>
                  <th>Empresas</th>             
                  <th>Tipo norma</th>                                                    
                  <th>Emisión</th>
                  <th>norma</th> 
                  <th>articulo</th> 
                  <th>Descripcion</th>                        
                  <th>Fecha</th>
                  <th>total </th>                 
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>Info-extra
            </h4>
         </div>
         <div class="modal-body">
         <style>
          .fix_headerborder{
            border-bottom: 2px solid black !important;
          }
         </style>              
            <div class="row">  
              <div class="col-lg-12">
                <table  style="font-size: 75%;" class="table">
          <thead>
              <tr>
                  <th class="fix_headerborder">Factor</th>
                  <th class="fix_headerborder">Categoria</th>              
                  <th class="fix_headerborder">Desc Norma</th>
                  <th class="fix_headerborder">Normas Relacionadas</th>                
              </tr>
            </thead>
            <tbody>
               <td id="factor" contenteditable="false" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"></td>
               <td id="categoria" contenteditable="false" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"></td>
               <td id="descnorma" contenteditable="false" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"></td>
               <td id="nrelacionada" contenteditable="false" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"></td>
            </tbody>
        </table>        
              </div>
            </div>      
         </div>
         <div class="modal-footer">
            <button type="button"  id="close_category" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" id="save_category" class="btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
         </div>
      </div>
   </div>
</div>



<div class="modal fade" id="modalpassdata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>Pasar datos
            </h4>
            <a href="{{route('delete_no_valid_2')}}"><button>Eliminar datos</button></a>
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

<script>
$(document).ready(function(){
$('#example').DataTable({
   "bSort": false,
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

function addinfoextra(descnorma,nrelacionada,id,factor,categoria){
      console.log('existo');
      $("#factor").empty();
      $("#categoria").empty();
      $("#descnorma").empty();
      $("#nrelacionada").empty();
            
      $("#factor").removeAttr('class');
      $("#categoria").removeAttr('class');
      $("#descnorma").removeAttr('class');
      $("#nrelacionada").removeAttr('class');
      
      $("#factor").append(factor);
      $("#categoria").append(categoria);      
      $("#descnorma").append(descnorma);
      $("#nrelacionada").append(nrelacionada);
      
      $("#factor").addClass('factor'+id);
      $("#categoria").addClass('categoria'+id);      
      $("#descnorma").removeAttr('descnorma'+id);
      $("#nrelacionada").removeAttr('nrelacionada'+id);
      
    }

     $(document).ready(function() {
      $("#manual_fixing").click(event => {
        
        console.log('funcion');
          /*$.get(`management_filterenterprise`+`/${event.target.value}`, function(res){
              $('#ajax-content').empty();
              $('#ajax-content').html(res);
               $('#example').DataTable({"bSort": false,fixedHeader:{header: true,footer: true},"pageLength": 50});
            });
            disable_elements(1);*/
             
        });
    });

 

     $(document).ready(function() {
      $("#empresa").change(event => {
        //console.log("Estoy llegando");
        if($("#empresa").val()!='')
        {
          $.get(`fixing_filter`+`/${event.target.value}`, function(res){
              $('#ajax-content').empty();
              $('#ajax-content').html(res);
              table = $('#example').DataTable({"bSort": false,
               "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
                   },
               fixedHeader: {
                    header: true        
                },"pageLength": 50});
              console.log(table.data().count());
            });            
        }
       });   
    });

  function pass_data()
 {
  $("#modalpassdata").modal('show');
 }
 
 $("#make_passdata").click(function(){
  if($("#passdata").val()!="")     
    {window.location.href = 'passdata2/'+$("#passdata").val();}
  else {
    alert("debes seleccionar una empresa");
  }   
});   

</script>

@stop 