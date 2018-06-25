
<!-- este formulario es  para crear una  las  normas-->
			<style>
			 #comentario {
			 	height: 100px;
			 }
			</style>

			{{Html::script('js/setComentario.js')}}	       

		    <form  id="cargar"  method="post"  action="Comentario" class="formarchivo" enctype="multipart/form-data" > 

			<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

			<input type="hidden" name="idevaluacion" value="{{ $id }}" id="idevaluacion">

			<div class="form-group">
				{!!Form::label('Comentario')!!}
				{!!Form::textarea('comentario',null,['id'=>'comentario','class'=>'form-control','size'=>'30x5'])!!}
			</div> 

			<div class="form-group">
				{!!Form::label('Adjunto')!!}
				<input name="archivo" id="archivo" type="file"   class="archivo form-control"  />
			</div> 

			 <div class="box-footer">
                 <button type="submit" class="btn btn-primary">Cargar Datos</button>
     		 </div>

		{!!Form::close()!!}


