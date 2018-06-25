@extends('layouts.admin')


  @section('content')
<br>
	
<?php $message=Session::get('message')?>

@if($message == 'store')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Documento guardado exitosamente</strong>  
</div>
@endif
@if($message == 'updated')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Documento Actualizado exitosamente</strong>  
</div>
@endif
@if($message == 'invalid')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Solo se permiten documentos en formato doc , docx , ppx , pptx , xlsx y pdf</strong>  
</div>
@endif
@if($message == 'deleted')
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Documento Borrado</strong>  
</div>
@endif
    @if(count($errors)>0)
        <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <ul>
            @foreach($errors->all() as $error)
              <li>{!!$error!!}</li>
            @endforeach 
           </ul>
         </div>
   @endif 


  @include('matriz.forms.modal')
    @if(Auth::user()->rol_id==1||Auth::user()->rol_id==2)


  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
       <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">         
   
            <span > Anexar {{$categoria->nombre}} </span>

        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">  
    <div class="panel-body">   
      <section class="content-header">
        
        <h4> <i class="fa fa-list-ul"></i> {{$categoria->nombre}} </h4>
        <!-- este formulario es  para crear una  las  normas-->
  


        
      <div class="box box-primary" style="max-width:500px !important;">
      <div class="box-header with-border">
      </div>

        <form  id="cargar"  method="post"  action="Documentos/save" class="formarchivo" enctype="multipart/form-data" > 

         <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

         <input type="hidden" name="categoria" value="{{ $categoria->id }}" id="token">


         <div class="form-group">
          {!!Form::label('Empresa')!!}
          {!!Form::select('empresa',$empresas,null,['id'=>'empresa','class'=>'form-control','placeholder'=>'Selecciona','required'])!!}
         </div>  

        <div class="form-group"> 
          {!!Form::label('Mes')!!}
            <input type="month" name="mes" class="form-control" required>            
          
        </div>

          <div class="form-group">
            {!!Form::label('Titulo del documento')!!}
            {!!Form::text('nombre',null,['id'=>'nombre','class'=>'form-control','size'=>'30x5'])!!}
          </div> 

          <div class="form-group">
            {!!Form::label('Adjunto')!!}
            <input name="archivo" id="archivo" type="file"   class="archivo form-control"  required/>
          </div>

          <div class="form-group">
            {!!Form::label('anexo')!!}
            <input name="archivo2" id="archivo2" type="file"   class="archivo form-control"  />
          </div> 

           <div class="box-footer">
                     <button type="submit" class="btn btn-primary">Cargar Datos</button>
             </div>

        {!!Form::close()!!}
       </div>
      </section>
    </div>
  </div>
</div>
</div>

  
  @endif
  <style>
    .inactive {
       pointer-events: none;
       cursor: default;
    } 
  </style>

  	<section class="content-header">

    	<h4> <i class="fa fa-list-ul"></i> Lista de {{$categoria->nombre}}</h4>
    	<ol class="breadcrumb">
    	<div class="table-responsive ocultar_400px">
     <div class="box box-primary" style="max-width:900px !important;">
      <div class="box-header with-border">
        <h3 class="box-title">{{$categoria->nombre}}</h3>          
      </div>
        <div class="form-group">
          <input type="hidden" id="catdoc" value="{{$id}}">
          {!!Form::label('Empresa')!!}
          {!!Form::select('enterprise',$empresas,null,['id'=>'enterprise','class'=>'form-control','placeholder'=>'Selecciona','required'])!!}
          {!!Form::label('Año')!!}
          {!!Form::select('year',$years,null,['id'=>'year','class'=>'form-control','placeholder'=>'Selecciona','required'])!!}
         </div>
         <div id="ajax-content">         
           <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
         		<thead>
                <tr class=table_head>
                 <th>Mes</th>    
                 <th>Título</th> 
                 <th>Adjunto</th>
                 @if(Auth::user()->rol_id==1)
                  <th>Anexo</th>
                 @endif
                 <th>Usuario</th>
                 <th>Empresa</th>
                 <th>Boton</th>
                  @if($id==8)
                    <th>Borrar</th>
                  @endif                 
                </tr>  
         		</thead>
         		 <tbody>
              
            @foreach($documentos as $documento)
              <tr>
                <td>  {{Sig\Helpers\Externclass::month_name($documento->mes)}}  </td>                
                <td>  {{$documento->nombre}} </td>
                <td>  <a  href="downloaddocumento/{{$documento ->archivo}}" >{{Sig\Helpers\Externclass::clean_name_doc($documento->archivo)}}</a></td>
                @if(Auth::user()->rol_id==1)
                  <td> @if($documento ->anexo != null) <a href="downloadanexo/{{$documento ->anexo}}">Anexo</a> @endif</td>
                @endif
                <td> {{Sig\Helpers\Externclass::user_name($documento->user)}}</td>        
                <td>  {{$documento->empresas->nombre}} </td> 
                @if(Auth::user()->rol_id!=3)
                <td>
                <button href="#"  class="btn btn-warning boletinedit" value="{{$documento->id}}" data-target='#myModal' data-toggle='modal' onclick="ajaxfunct({{$documento->id}})">Editar</button>
               </td> 
               @else
               <td></td>
               @endif
                 @if($id==8)
                  <td>
                  <a onclick="return validate()" href="deletedoc/{{$documento->id}}">
                    <button   class="btn btn-danger boletinedit" >Borrar</button>
                  </a>
                 </td>               
                 @endif
              </tr>  
            @endforeach  
         		 </tbody>         	
         	</table> 
        </div>
      </div>
      </div>
      </ol>
      </section>
      <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
      <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
      <script>
       
        $(document).ready(function() {
          $('#example').DataTable({
             "bSort": false,
             "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
              }
            });
        });


        function ajaxfunct(id) { 
          $('.datoscumplimiento').empty();
              var load = "<div class='loader'><span></span><span></span> <span></span></div>";
              $(".datoscumplimiento").html(load)  
            
              var prueba= $.get(`gDocumentoedit/`+id, function(res){
                var dato = res;
               
                $('.datoscumplimiento').empty();
                $(".datoscumplimiento").html(dato);
           });               
        }

        $(document).ready(function() {
          $("#enterprise").change(event => {
            //console.log("Estoy llegando");
            if($("#year").val()==''){
              year = 0;
            }

            else{
              year = $("#year").val();
            }
            
            $.get(`filter_view/`+$("#catdoc").val()+`/`+year+`/${event.target.value}`, function(res){
                    $('#ajax-content').empty();
                    $('#ajax-content').html(res);
                     $('#example').DataTable({"bSort": false});
                });
            });
        });

        $(document).ready(function() {
          $("#year").change(event => {
            //console.log("Estoy llegando");
            if($("#enterprise").val()==''){
              enterprise = 0;
            }

            else{
              enterprise = $("#enterprise").val();
            }
            
            $.get(`filter_view/`+$("#catdoc").val()+`/${event.target.value}`+`/`+enterprise, function(res){
                  $('#ajax-content').empty();
                  $('#ajax-content').html(res);
                   $('#example').DataTable({"bSort": false,"language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
       }});
                });
            });
        });

        function validate(){
          if(!confirm("Está seguro de borrar el archivo?"))
          {
            return false;
          }
          return true;
        }

      </script>

 <!--
          var prueba =res;
              
              if(res==="Ninguno"){
                $("#norma").append(`<option>No tiene asignado</option>`);   
              }
              else{
                   //$("#articulos").append(`<option>Selecciona</option>`);
                   var f=`<option selected>Normas disponibles</option>`;
              res.forEach(element => {
                 //$("#Articulos").append(`<option value=${element.id}>${element.numero_articulo} </option>`);
                 f=f+`<option value=${element.id}>${element.numero_norma} </option>`;
              });
              //console.log("este es el texto "+f);
               $("#norma").append(f);
              }
-->
@stop