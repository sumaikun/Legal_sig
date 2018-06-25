
	        <form method="POST" action="editionS/{{$id}}" accept-charset="UTF-8">

	        	<input name="_method" type="hidden" value="PUT">
	        	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
		
	            
       			 <div class="form-group">
                	{!!Form::label('Sector')!!}
                	<input id="sector" class="form-control" placeholder="Ingrese el nombre del nuevo sector" maxlength="60" required="required" minlength="10" name="sector" type="text" value="{{$sector->sector}}">
                 </div>
				
				<input class="btn btn-primary" type="submit" value="Actualizar"> 
	        </form>