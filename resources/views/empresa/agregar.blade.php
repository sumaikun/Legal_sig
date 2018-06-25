@extends('layouts.admin')


	@section('content')

		<br>
		<style>
			.title{
				font-size: 200%;
				font-weight: bold;
			}
		</style>
		<?php $message=Session::get('message')?>

		@if($message == 'invalid')
		<div class="alert alert-warning alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong>Los campos de sector e industria deben tener valores validos</strong>  
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
	    <!-- este formulario  es  para crear una empresa -->
	     <div class="box box-primary" style="max-width:500px !important;">
		  <div class="box-header with-border">
		    <h3 class="box-title">Crear Empresas</h3>
		  </div>
			{!!Form::open(['route'=>'Empresa.store','method'=>'POST','files'=>true])!!}
				@include('empresa.forms.create');
				 
	           {!!Form::submit('Registrar',['class'=>'btn btn-primary'])!!}
			   {!!Form::close()!!}
		</div> 
	
		@endsection

		   @section('script')
		   {!!Html::script('js/dropdown.js')!!}

	@stop