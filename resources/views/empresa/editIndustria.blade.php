
	        <form method="POST" action="editionI/{{$id}}" accept-charset="UTF-8">

	        	<input name="_method" type="hidden" value="PUT">
	        	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
		
	            		<div class="form-group">
	            <select id="sector" required="required" class="form-control" name="sector">
	            	<option  value="">Selecciona</option>
	            	@foreach($sector as $key =>$item)   
	            		@if($key == $industria->sector_id)
	            		<option value={{$key}} selected>{{$item}}</option>
	            		@else         		
						<option value={{$key}}>{{$item}}</option>
						@endif	            		
	            	@endforeach
            	</select>		
				 
            </div>
       			 <div class="form-group">
                	{!!Form::label('Industria')!!}
                	<input id="industria" class="form-control" placeholder="Ingrese el nombre del nuevo sector" maxlength="60" required="required" minlength="10" name="industria" type="text" value="{{$industria->industria}}">
                 </div>
				
				<input class="btn btn-primary" type="submit" value="Actualizar"> 
	        </form>