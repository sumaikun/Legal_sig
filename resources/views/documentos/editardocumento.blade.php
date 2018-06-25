
	        <form method="POST" action="Documentos/update" accept-charset="UTF-8" enctype="multipart/form-data">

	        	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
	        	<input type="hidden" name="id" value="{{ $id }}" id="id">
			    <div class="form-group">
                <div class="form-group">
          			{!!Form::label('Empresa')!!}
          			<select id="empresa" class="form-control" required="required" name="empresa" required>
                  <option value="">Selecciona</option>
                  @foreach($empresas as $key => $temp)
                    <option value={{$key}} @if($key==$documento->empresa) {{'selected'}}  @endif>{{$temp}}</option>
                  @endforeach
                </select>
        		</div>  

       			<div class="form-group"> 
          			{!!Form::label('Mes')!!}
          		  	<input type="month" name="mes" class="form-control" value="{{substr($documento->mes,0,7)}}" required>            
          
        		</div>
          		<div class="form-group">
            		{!!Form::label('Titulo documento ')!!}
            		<input id="nombre" class="form-control" size="30x5" required="required" name="nombre" type="text" value="{{$documento->nombre}}">
          		</div> 

          		<div class="form-group">
            		{!!Form::label('Adjunto')!!}
           		 	<input name="archivo" id="archivo" type="file"   class="archivo form-control">
          		</div> 

            <div class="form-group">
              {!!Form::label('anexo')!!}
              <input name="archivo2" id="archivo2" type="file"   class="archivo form-control"  />
            </div> 

             <div class="form-group">
                <div class="form-group">
                {!!Form::label('Categoria a la que pertenece')!!}
                <select id="categoria" class="form-control" required="required" name="categoria" required>
                  <option value="">Selecciona</option>
                  @foreach($categorias as $key => $temp)
                    <option value={{$key}} @if($key==$documento->id_categoria) {{'selected'}}  @endif>{{$temp}}</option>
                  @endforeach
                </select>
            </div>  
				
				<input class="btn btn-primary" type="submit" value="Actualizar"> 
	        </form>