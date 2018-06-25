		{{Html::script('js/setComentarioedit.js')}}
	        <form method="POST" action="Comentario/{{$id}}" accept-charset="UTF-8" enctype="multipart/form-data" id="insideform">

	        	<input name="_method" type="hidden" value="PUT">
	        	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
			    <input type="hidden" name="idevaluacion" value="{{$comentario->evaluacion_id}}" id="idevaluacion">
			    <input type="hidden" name="id" value="{{$comentario->id}}" id="id">

				<div class="form-group">
					<label for="Comentario">Comentario</label>
					<textarea id="comentario" class="form-control" name="comentario" cols="30" rows="5"></textarea>
				</div> 

				<div class="form-group">
					<label for="Adjunto">Adjunto</label>
					<input name="archivo" id="archivo" type="file" class="archivo form-control">
				</div> 	       
				
				<input class="btn btn-primary" type="submit" value="Actualizar"> 
	        </form>

	        <script>
	        var id= {{$id}};
	        </script>