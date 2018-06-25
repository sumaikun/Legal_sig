     {!!Form::open(['id'=>'insideform','route'=>'Empresa.sector'])!!}

         
  
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
     

         <div class="form-group">
                {!!Form::label('Sector')!!}
                {!!Form::text('sector',null,['id'=>'sector','class'=>'form-control','placeholder'=>'Ingrese el nombre del nuevo sector', 'maxlength'=>'60','required','minlength'=>'8'])!!}
         </div>

  
         </div>
           {!!Form::submit('Registrar',['class'=>'btn btn-primary ','id'=>'submit'])!!}