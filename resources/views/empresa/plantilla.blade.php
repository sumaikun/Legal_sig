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
@if($message == 'repeated')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>El documento ya existe</strong>  
</div>
@endif
@if($message == 'erased')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>El documento fue borrado</strong>  
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


  @include('Matriz.forms.modal')
  	<section class="content-header">
    	<h4> <i class="fa fa-list-ul"></i> Lista </h4>
    	<ol class="breadcrumb">
    	<div class="table-responsive ocultar_400px">
     <div class="box box-primary" style="max-width:600px !important;">
      <div class="box-header with-border">
        <h3 class="box-title">Plantillas</h3>
      </div>        
         <table class ="table">
         		<thead>
                <tr class=table_head>
                  <th>empresa</th>
                  <th>Plantilla</th>
                 <th></th>                 
                </tr>  
         		</thead>
         		 <tbody>
       
              
            @foreach($empresas as $empresa)
             <tr>
                <td>  {{$empresa}} </td>                
                <td>  <a href="downloadlayout/{{$empresa}}"><img src="http://icons.iconarchive.com/icons/graphicloads/filetype/128/excel-xls-icon.png"/></a> </td>    
                <td> <a href="deletelayout/{{$empresa}}"><button class="btn btn-danger">Borrar</button></a> </td>            
             </tr>  
            @endforeach  
         		 </tbody>
         	
         	</table> 
      </div>
      </div>
      </ol>
      </section>

 

  @if(Auth::user()->rol_id==1||Auth::user()->rol_id==2)


  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
       <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">         
   
            <span > Anexar Plantilla </span>

        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">  
    <div class="panel-body">   
      <section class="content-header">
   
        <h4> <i class="fa fa-list-ul"></i> Plantilla </h4>
        <!-- este formulario es  para crear una  las  normas-->


        
      <div class="box box-primary" style="max-width:500px !important;">
      <div class="box-header with-border">
      </div>

        <form  id="cargar"  method="post"  action="Plantilla/save" class="formarchivo" enctype="multipart/form-data" > 

         <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

         <div class="form-group">
          {!!Form::label('Empresa')!!}
          <select id="empresa" class="form-control" required="required" name="empresa">
              <option selected="selected" value="">Selecciona</option>
              @foreach($empresas as $empresa)
                <option value="{{$empresa}}">{{$empresa}}</option>
              @endforeach  
          </select>
         </div>         

          <div class="form-group">
            {!!Form::label('Adjunto')!!}
            <input name="archivo" id="archivo" type="file"   class="archivo form-control"  required/>
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
  {{Html::script('js/GetBoletinedit.js')}}
  @endif
@stop