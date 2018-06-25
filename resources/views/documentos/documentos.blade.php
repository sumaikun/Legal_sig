@extends('layouts.admin')


  @section('content')
<br>
	
<?php $message=Session::get('message')?>

@if($message == 'store')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Categoria creada exitosamente</strong>  
</div>
@endif
@if($message == 'updated')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Categoria Actualizada exitosamente</strong>  
</div>
@endif
@if($message == 'failed')
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Ya existe la categoria</strong>  
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
   
            <span > Crear Categoria </span>

        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">  
    <div class="panel-body">   
      <section class="content-header">
        
        <h4> <i class="fa fa-list-ul"></i> Categorias </h4>
        <!-- este formulario es  para crear una  las  normas-->
  


        
      <div class="box box-primary" style="max-width:500px !important;">
      <div class="box-header with-border">
      </div>

        <form  id="cargar"  method="post"  action="Categoria/save" class="formarchivo" enctype="multipart/form-data" > 

         <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

          <div class="form-group">
            {!!Form::label('Nombre de categoria')!!}
            {!!Form::text('nombre',null,['id'=>'titulo','class'=>'form-control','size'=>'30x5','required'=>'required'])!!}
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
    <section class="content-header">

      <h4> <i class="fa fa-list-ul"></i> Lista de Categorias</h4>
      <ol class="breadcrumb">
      <div class="table-responsive ocultar_400px">
     <div class="box box-primary" style="max-width:600px !important;">
      <div class="box-header with-border">
        <h3 class="box-title">Categoria</h3>          
      </div>        
       <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr class=table_head>
             <th>Nombre Categoria</th>
             <th style="text-align: center;">Ingresar a Categoria</th>    
             @if(Auth::user()->rol_id!=3)
             <th style="text-align: center;"> Botones </th> 
             @endif                           
            </tr>  
        </thead>
        <tbody>
          
          @foreach($categorias as $categoria)
            @if($categoria->id!=8)
            <tr>                         
              <td>  {{$categoria->nombre}} </td>          
              <td style="text-align: center;"> <a href="ingresarCategoria/{{$categoria->id}} "><button class="btn fa fa-child"> Ingresar</button></a> </td>
              @if(Auth::user()->rol_id!=3)
              <td style="text-align: center;">
              <button href="#" id="{{$categoria->id}}" class="btn btn-warning boletinedit" value="{{$categoria->id}}" data-target='#myModal' data-toggle='modal' onclick="ajaxfunct({{$categoria->id}})">Editar</button>
             </td> 
             @else
             <td></td>
             @endif
          </tr>
          @endif  
          @endforeach
           @if(Auth::user()->rol_id!=3)
            <tr style="background-color: #04B404;">                         
              <td>  <strong>{{$categorias[7]->nombre}}</strong> </td>          
              <td style="text-align: center;"> <a href="ingresarCategoria/{{$categorias[7]->id}} "><button class="btn fa fa-child"> Ingresar</button></a> </td>              
             <td></td>            
            </tr>
          @endif 
       </tbody>      
      </table>

      </div>
      </div>
      </ol>
      </section>
      <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
      <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
     
<script>
function ajaxfunct(id) { 
  $('.datoscumplimiento').empty();
      var load = "<div class='loader'><span></span><span></span> <span></span></div>";
      $(".datoscumplimiento").html(load)  
    
      var prueba= $.get(`gCategoriaedit/`+id, function(res){
        var dato = res;
       
        $('.datoscumplimiento').empty();
        $(".datoscumplimiento").html(dato);
   });               
}


</script>

 
@stop
