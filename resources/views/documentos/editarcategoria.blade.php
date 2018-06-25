<form  id="cargar"  method="post"  action="Categoria/update" class="formarchivo" enctype="multipart/form-data" > 

 	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
	
	<input type="hidden" name="id" value="{{$categoria->id}}">

  <div class="form-group">
    {!!Form::label('Nombre de categoria')!!}
    <input type="text" class="form-control"  value="{{$categoria->nombre}}" name="nombre" required>
  </div> 


  <div class="box-footer">
         <button type="submit" class="btn btn-primary">Cargar Datos</button>
  </div>
</form>  