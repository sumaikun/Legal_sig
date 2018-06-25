
@extends('layouts.admin')
	@section('content')

	     <!-- este formulario es para derogar norma -->
	     	

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


	     

		{!!Form::open(['route'=>'Derogada.store', 'method'=>'POST'])!!}

		
		 <div class="form-group">
				{!!Form::label('Tipo de Norma')!!}
				{!!Form::select('tipo_norma_id',$tipo,null,['id'=>'tipo_norma_id','class'=>'form-control'])!!}
		</div>  
		    

		   <div class="form-group">
				{!!Form::label('Numeros')!!}
				{!!Form::select('norma_id',$norma,null,['id'=>'norma_id','class'=>'form-control'])!!}
		   </div>   

		   <div class="form-group">
				{!!Form::label('Año de emisión')!!}
				{!!Form::text('year',null,['id'=>'year','class'=>'form-control'])!!}
		    </div> 

		    <div class="form-group">
				{!!Form::label('Autoridad Emisora')!!}
				{!!Form::text('autoridad',null,['id'=>'autoridad','class'=>'form-control'])!!}
		    </div>  

		   <div class="form-group">
				{!!Form::label('Fecha de derogación')!!}
				{!!Form::date('fecha',null,['id'=>'fecha','class'=>'form-control'])!!}
		    </div>

			

		   <div class="form-group">
				{!!Form::label('Comentario')!!}
				{!!Form::text('comentario',null,['id'=>'comentario','class'=>'form-control'])!!}
			</div>

			<div class="form-group">
				{!!Form::label('Usuario')!!}
				{!!Form::select('usuario_id',$usuario,null,['id'=>'usuario_id','class'=>'form-control'])!!}
		    </div>


		
				{!!Form::submit('Registrar',['class'=>'btn btn-primary'])!!}
		{!!Form::close()!!}


	@stop