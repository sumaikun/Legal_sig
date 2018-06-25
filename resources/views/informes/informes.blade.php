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
@if($message == 'update')
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
   
            <span > Anexar Informe </span>

        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">  
    <div class="panel-body">   
      <section class="content-header">
   
        <h4> <i class="fa fa-list-ul"></i> Informes </h4>
        <!-- este formulario es  para crear una  las  normas-->
  


        
      <div class="box box-primary" style="max-width:500px !important;">
      <div class="box-header with-border">
      </div>
          <form  id="cargar"  method="post"  action="Informes/save" class="formarchivo" enctype="multipart/form-data" > 

          <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

         <div class="form-group">
          {!!Form::label('Empresa')!!}
          {!!Form::select('empresa',$empresas,null,['id'=>'empresa','class'=>'form-control','placeholder'=>'Selecciona','required'])!!}
         </div>  

        <div class="form-group"> 
          {!!Form::label('Mes')!!}
            <input type="month" name="mes" class="form-control" required>            
          
        </div>
          <div class="form-group">
            {!!Form::label('Titulo Informe')!!}
            {!!Form::text('titulo',null,['id'=>'titulo','class'=>'form-control','size'=>'30x5','required'])!!}
          </div> 

          <div class="form-group">
            {!!Form::label('Adjunto')!!}
            <input name="archivo" id="archivo" type="file"   class="archivo form-control" required>
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
 {{Html::script('js/GetInformesedit.js')}}
@endif
 



  	<section class="content-header">
   
    	<h4> <i class="fa fa-list-ul"></i> Lista de Informes</h4>
    	<ol class="breadcrumb">
    	<div class="table-responsive ocultar_400px">
     <div class="box box-primary" style="max-width:600px !important;">
      <div class="box-header with-border">
        <h3 class="box-title">Informes</h3>         
      </div>        
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
         		<thead>
                <tr class=table_head>
                 <th>Mes</th>    
                 <th>Título</th> 
                 <th>Adjunto</th>
                 <th>Usuario</th>
                 <th>Empresa</th>
                 <th></th>
                </tr>  
         		</thead>
         		 <tbody>
              
            @foreach($informes as $informe)
              <tr>
                <td>  {{Sig\Helpers\Externclass::month_name($informe->mes)}}  </td>                
                <td>  {{$informe->titulo}} </td>
                <td>  <a  href="downloadtree/{{$informe ->archivo}}" >{{Sig\Helpers\Externclass::clean_name_doc($informe->archivo)}}</a></td>
	 	    		 	  <td>  {{Sig\Helpers\Externclass::user_name($informe->usuario)}}</td> 
                <td>  {{$empresas[$informe->empresa]}} </td> 
                @if(Auth::user()->rol_id!=3)
                <td>
                <button href="#" id="{{$informe->id}}" class="btn btn-warning Informesedit" value="{{$informe->id}}" data-target='#myModal' data-toggle='modal' onclick="informe.setid({{$informe->id}})">Editar</button>
               </td>
               @else
               <td></td>
               @endif   	
      	      </tr>  
            @endforeach  
         		 </tbody>
         	
         	</table> 
        
      </div>
      </div>
      </ol>
      </section>
      <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
      <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
      <script>
        var informe = new Object();
        informe.id=0;
        informe.setid=function(id)
        {
          informe.id = id;
          //console.log("capture el id"+factor.id);
        }
        $(document).ready(function() {
          $('#example').DataTable();
        });
      </script>    


  {{Html::script('js/data_search.js')}}
@stop