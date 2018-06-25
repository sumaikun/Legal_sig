
@extends('layouts.admin')
	@section('content')
	    @if(count($errors)>0)
			  <div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			 	 <ul>
			  		@foreach($errors->all() as $error)
			  		<br>
			  			<li>{!!$error!!}</li>
			  		@endforeach	
			  	 </ul>
   	         </div>
         @endif 
	     <!-- este formulario es para modificar /editar empresa -->
	     	<tr></tr>
	     	<br>
		     <div class="box box-primary" style="max-width:500px !important;">
				  <div class="box-header with-border">
				    <h3 class="box-title">Editar Empresa</h3>
				  </div>
				    {!!Form::model($ents,['route'=>['Empresa.update',$ents->idempresa],'method'=>'PUT','files'=>true])!!}

						<div class="form-group">
							*{!!Form::label('Nombre')!!}
							{!!Form::text('nombre',null,['id'=>'nombre','class'=>'form-control','required'])!!}
						</div>
						<div class="form-group">
							*{!!Form::label('Representante')!!}
							{!!Form::text('representante_legal',null,['id'=>'representante_legal','class'=>'form-control', 'maxlength'=>'50'])!!}
						</div>
						
						<div class="form-group">
							*{!!Form::label('Cargo del Respresentante')!!}
							{!!Form::text('cargo',null,['id'=>'cargo','class'=>'form-control','maxlength'=>'50'])!!}
						</div>
						
						<div class="form-group">
							<textarea id="comentario" class="form-control" style="max-height: 100px !important;" maxlength="280" name="comentario" cols="50" rows="10">{{$ents->comentario}}
							</textarea>
						</div>
						<div class="load" style='max-height:0px !important'>  
		                </div>
						<div class="form-group">
							<label for="Sector">Sector</label>
			            	<select id="sector"  name="sector">
			            		<option value="">Selecciona</option>
			            		@foreach($sectores as $key => $temp)
			            			<option @if($ents->sector_id==$key) {{'selected'}} @endif value="{{$key}}">{{$temp}}</option>
			            		@endforeach
			            	</select>		            
			            </div>
			           <div class="form-group">
			            	<label for="Industria">Industria</label>
							<select id="industria"  name="industria">
								<option value="placeholder">Selecciona</option>
							</select>	
						</div>
			            
			            @if(isset($intg2))
			            <div class="form-group">
							{!!Form::label('Logo')!!}
							{!!Form::file('logo')!!}
						</div>
			            @else
			            <div class="form-group">
							{!!Form::label('Logo')!!}
							{!!Form::file('logo',['required'])!!}
						</div>
						@endif

			         	<div class="form-group">
			            <span class="title">Tipo de Calificación</span>
			            <br>
							<label for="0-100">0-100</label>
							<input @if($ents->calificacion==1) {{'checked'}} @endif name="tipoevaluacion" type="radio" value="1">
							<label for="0-50-100">0-50-100</label>
							<input @if($ents->calificacion==2) {{'checked'}} @endif name="tipoevaluacion" type="radio" value="2">
						</div>	
					
					{!!Form::submit('Actualizar',['class'=>'btn btn-primary'])!!} <!-- <tr> {!!link_to_route('Empresa.show',$title = 'Cambiar Estado' , $parameters = $ents->idempresa,$attributes =['class'=>'btn btn-primary'])!!} </tr> -->
						
					{!!Form::close()!!}

					Los espacios marcados con * son obligatorios
			</div>	

	<script>

	busca_industrias();
		
	function busca_industrias()
	{	
	      var load = "<div class='loader'><span></span><span></span> <span></span></div>";
	     $(".load").html(load)	
	     if($("#sector").val()=="")
	     {
	     	$("#industria").empty();
	     	$("#industria").append('<option> Selecciona <option>');
			$(".load").empty();
	     }
	     else
	     { 
			$.get('industria/'+$("#sector").val(), function(res, sta){
				$("#industria").empty();
				$(".load").empty();
				res.forEach(element => {
					$("#industria").append(`<option value=${element.idindustria}> ${element.industria} </option>`);
				});
			});
		}
	}


	</script>
	
	@endsection

	   @section('script')
	   {!!Html::script('js/dropdown.js')!!}

	@stop