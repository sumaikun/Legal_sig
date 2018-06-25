 
     {!!Form::open(['id'=>'insideform','route'=>'Empresa.industria'])!!}         
  
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
			<div class="form-group">
				{!!Form::label('Sector')!!}
	            {!!Form::select('sector',$sector,null,['id'=>'sector','placeholder'=>'Selecciona','required','class'=>'form-control'])!!} 
            </div>


         <div class="form-group">
                {!!Form::label('Industria')!!}
                {!!Form::text('industria',null,['id'=>'industria','class'=>'form-control','placeholder'=>'Ingrese el nombre de la nueva industria', 'maxlength'=>'60','required','minlength'=>'8'])!!}
         </div>

  
         </div>
           {!!Form::submit('Registrar',['class'=>'btn btn-primary ','id'=>'submit'])!!}