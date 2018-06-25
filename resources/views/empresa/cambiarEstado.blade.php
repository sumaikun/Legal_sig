@extends('layouts.admin')
@section('content')




	     <!-- este formulario  es  para  cambiaer  estado de  empresa -->
	     	<tr></tr>
	     	<br>
		{!!Form::model($ents,['route'=>['Empresa.update',$ents->idempresa], 'method'=>'PUT'])!!}


			<div class="form-group">
				{!!Form::label('Estado')!!}
				{!!Form::select('estado',['1' => 'Activo', '2' => 'Inactivo', '3' => 'Mora' ],null,['id'=>'estado','class'=>'form-control'])!!}
			</div>
				{!!Form::submit('Registrar',['class'=>'btn btn-primary'])!!}
		{!!Form::close()!!}






@stop	