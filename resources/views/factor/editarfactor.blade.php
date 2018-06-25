
	        <form method="POST" action="Factor/{{$id}}" accept-charset="UTF-8">

	        	<input name="_method" type="hidden" value="PUT">
	        	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
			    <div class="form-group">
	            <label for="Nombre">Nombre</label>
	            <input id="nombre" class="form-control" required="required" maxlength="40" name="nombre" type="text" value="{{$factor->nombre}}">
	           </div>
	       
				
				<input class="btn btn-primary" type="submit" value="Actualizar"> 
	        </form>