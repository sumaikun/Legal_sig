@extends('layouts.admin')
	@section('content')
    <?php $message=Session::get('message')?>
    <br>
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
         
        @if($message =='error_correos')
				<div class="alert alert-warning alert-dismissible" role="alert">
 				 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  				<strong>Ya existe un correo igual en la base de datos</strong>  
				</div>
		@endif

        @if($message =='invalid')
				<div class="alert alert-warning alert-dismissible" role="alert">
 				 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  				<strong>Ingreso inadecuado de datos</strong>  
				</div>
		@endif		
	     <!-- este for
	     <!-- este formulario  es  para editar un usuario -->
	     	<tr></tr>
	     	<br>
	       <div class="box box-primary" style="max-width:500px !important;">
			  <div class="box-header with-border">
			    <h3 class="box-title">Editar Usuarios</h3>
			  </div>
			  <div class="box-body">  	
				{!!Form::model($user,['route'=>['Usuario.update',$user->idusuario], 'method'=>'PUT'])!!}

					<div class="form-group">
						{!!Form::label('Nombre')!!}
						{!!Form::text('nombre',null,['id'=>'nombre','class'=>'form-control','placeholder'=>'Ingresa el nombre del usuario','pattern'=>'^[A-Za-z ]+$','title'=>'No se permite ingresar numeros'])!!}
					</div>
					<div class="form-group">
						{!!Form::label('Usuario')!!}
						{!!Form::text('usuario',null,['disabled' => 'disabled','class'=>'form-control'])!!}
					</div>
					<div class="form-group">
						{!!Form::label('Contraseña')!!}				
						{!!Form::password('contrasena',['id'=>'contrasena','class'=>'form-control','placeholder'=>'Ingrese la contraseña','required'])!!}
					</div>
					<div class="form-group">
						{!!Form::label('Correo')!!}
						{!!Form::email('correo',null,['id'=>'correo','class'=>'form-control','placeholder'=>'Ingresa su correo electronico'])!!}
					</div>
					<div class="form-group">
						{!!Form::label('Rol')!!}
						{!!Form::select('rol',['1' => 'Administrador', '2' => 'Consultor', '3' => 'Cliente',],null,['id'=>'rol','class'=>'form-control','placeholder'=>'Selecciona','required'])!!}
					</div>
						{!!Form::submit('Actualizar',['class'=>'btn btn-primary'])!!} <tr> {!!link_to_route('Usuario.show',$title = 'Cambiar Estado' , $parameters = $user->idusuario,$attributes =['class'=>'btn btn-primary'])!!} </tr>
						
				{!!Form::close()!!}
			</div>
		</div>		

	@stop