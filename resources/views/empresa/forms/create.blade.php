	<div class="form-group">
					{!!Form::label('Nombre')!!}
					{!!Form::text('nombre',null,['id'=>'nombre','class'=>'form-control','maxlength'=>'50','required'])!!}
				</div>
				<div class="form-group">
					{!!Form::label('Representante')!!}
					{!!Form::text('representante_legal',null,['id'=>'representante_legal','class'=>'form-control', 'maxlength'=>'50'])!!}
				</div>
				
				<div class="form-group">
					{!!Form::label('Cargo del Respresentante')!!}
					{!!Form::text('cargo',null,['id'=>'cargo','class'=>'form-control','maxlength'=>'50'])!!}
				</div>
				
				<div class="form-group">
					{!!Form::label('Comentario')!!}
					{!!Form::textarea('comentario',null,['id'=>'comentario','class'=>'form-control','style'=>'max-height: 100px !important;' ,'maxlength'=>'280'])!!}
				</div>
				<div class="load" style='max-height:0px !important'>  
                </div>
				<div class="form-group">
				{!!Form::label('Sector')!!}
	            {!!Form::select('sector',$sector,null,['id'=>'sector','placeholder'=>'Selecciona','required'])!!}	            
	            </div>
	            <div class="form-group">
	            {!!Form::label('Industria')!!}
				{!!Form::select('industria',['placeholder'=>'Selecciona'],null,['id'=>'industria','required']) !!}	
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
					{!!Form::label('0-100')!!}
					{!!Form::radio('tipoevaluacion', '1',['required'])!!}
					{!!Form::label('0-50-100')!!}
					{!!Form::radio('tipoevaluacion', '2')!!}
				</div>		