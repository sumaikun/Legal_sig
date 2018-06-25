
	        <form method="POST" action="Informes/update" accept-charset="UTF-8" enctype="multipart/form-data">

	        	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
	        	<input type="hidden" name="id" value="{{ $id }}" id="id">
			    <div class="form-group">
                <div class="form-group">
          			{!!Form::label('Empresa')!!}
          			{!!Form::select('empresa',$empresas,null,['id'=>'empresa','class'=>'form-control','placeholder'=>'Selecciona','required'])!!}
        		</div>  

       			<div class="form-group"> 
          			{!!Form::label('Mes')!!}
          		  	<input type="month" name="mes" class="form-control" required>            
          
        		</div>
          		<div class="form-group">
            		{!!Form::label('Titulo documento juridico')!!}
            		<input id="titulo" class="form-control" size="30x5" required="required" name="titulo" type="text" value="{{$titulo}}">
          		</div> 

          		<div class="form-group">
            		{!!Form::label('Adjunto')!!}
           		 	<input name="archivo" id="archivo" type="file"   class="archivo form-control">
          		</div> 

	       
				
				<input class="btn btn-primary" type="submit" value="Actualizar"> 
	        </form>