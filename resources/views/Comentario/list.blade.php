

	
<?php $message=Session::get('message')?>

@if($message == 'store')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Comentario creado exitosamente</strong>  
</div>
@endif
@if($message == 'update')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Comentario Actualizado exitosamente</strong>  
</div>
@endif

    {{Html::script('js/setComentario.js')}}
    {{Html::script('js/GetComentarioedit.js')}}
  	<section class="content-header">
    	<h4> <i class="fa fa-list-ul"></i> Lista de Comentarios</h4>
    	<ol class="breadcrumb">
    	<div class="table-responsive ocultar_400px">
     <table class ="table">
     		<thead>
             <th>Fecha</th>    
             <th>Comentario</th> 
             <th>Adjunto</th>
             <th>Usuario</th> 
     		</thead>

     		 @foreach($comentarios as $comentario)

     		 <tbody>
          
             <td> {{ Carbon\Carbon::parse($comentario ->created_at)->format('d/m/Y')}}  </td>
             <td> {{$comentario ->comentario}}</td>
             @if($comentario ->archivo!='N.A')
             <td> <a  href="filedownload/{{$comentario ->archivo}}"   id="{{$comentario->id}}"  data-file="<?php echo $comentario ->archivo ?>">{{$comentario ->archivo}}</a></td>
             @else
             <td> N.A</td>            
             @endif
             <td> {{$usuarios[$comentario ->usuario_id]}}</td>     		 	    		 	        	
            @if($comentario ->usuario_id==Auth::user()->idusuario)
            <td>
              <button href="#" id="{{$comentario ->id}}" class="btn btn-warning Comentarioedit" value="{{$comentario ->id}}"  onclick="comentario.setid({{$comentario ->id}})">Editar</button>
            </td>
            @else
            <td></td>
     	      @endif  
     		 </tbody>
     		 @endforeach
     	</table> 
      <script>
        var comentario = new Object();
        comentario.id=0;
        comentario.setid=function(id)
        {
          comentario.id = id;
          console.log("capture el id"+comentario.id);
        }
        
      </script>


  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
       <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">         
   
            <span id=subrayado> Comentario </span>

        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">  
    <div class="panel-body">   
      <section class="content-header">
   
        <h4> <i class="fa fa-list-ul"></i> nuevo comentario </h4>
        @include('Comentario.comentario') 
  

      </section>  
     </div>
    </div>
  </div> 

