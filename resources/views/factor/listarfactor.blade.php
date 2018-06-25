
@extends('layouts.admin')
	
<?php $message=Session::get('message')?>

@if($message == 'store')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Factor de Riesgo creado exitosamente</strong>  
</div>
@endif

@if($message == 'update')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Factor de  Riesgo Actualizado exitosamente</strong>  
</div>
@endif

@if($message == 'repeated')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>El Factor de riesgo ya existe en el sistema o hay uno muy similar</strong>  
</div>
@endif

@if($message == 'deleted')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Dato Borrado</strong>  
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


	@section('content')

  {{Html::script('js/GetFactoredit.js')}}

  @include('matriz.forms.modal')
  <br>
  @if(Auth::user()->rol_id != 3)
      <div class="box box-primary" style="max-width:500px !important;">
      <div class="box-header with-border">
        <h3 class="box-title">Factor de riesgo - Agregar</h3>
              
           {!!Form::open(['route'=>'Factor.store','method'=>'POST'])!!}

            <div class="form-group">
            {!!Form::label('Nombre')!!}
            {!!Form::text('nombre',null,['id'=>'nombre','class'=>'form-control','required','maxlength'=>'40'])!!}
           </div>
       

    {!!Form::submit('Registrar',['class'=>'btn btn-primary'])!!}
    {!!Form::close()!!}
      </div>
      </div>
@endif

    <br>
  	<section class="content-header">
      <br>
	<h4> <i class="fa fa-list-ul"></i> Listar Factores de Riesgo </h4>
	<ol class="breadcrumb">
	<div class="table-responsive ocultar_400px">
    <table  id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr class="table_head">
     		    <th> Nombre  </th>
            <th></th>
            <th></th>
          </tr>   

     		 </thead>
     		 @foreach($ftr as $ftr)
     		 <tbody>
         <tr>
     		 	<td> {{$ftr->nombre}}  </td>
          @if(Auth::user()->rol_id != 3)
     		 	<td align="center">
     		 	<button href="#" id="{{$ftr->idfactor_riesgo}}" class="btn btn-warning Factoredit" value="{{$ftr->idfactor_riesgo}}" data-target='#myModal' data-toggle='modal' onclick="factor.setid({{$ftr->idfactor_riesgo}})">Editar</button>
          </td>
          @endif
          @if(Auth::user()->rol_id == 1)
          <td align="center"><a href="{{route('Factor.erase',$ftr->idfactor_riesgo)}}"><button class="btn btn-danger">Borrar</button></a></td>
          @endif            
     	    </tr>     		 
     		 @endforeach
         </tbody>
    	</table>
    </div>
    </ol>
    </section>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
      <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
      <script>
       
        $(document).ready(function(){
          $('#example').DataTable({
             "bSort": false
            });
        });

       </script> 


      <script>
        var factor = new Object();
        factor.id=0;
        factor.setid=function(id)
        {
          factor.id = id;
          //console.log("capture el id"+factor.id);
        }
        
      </script>


@stop	