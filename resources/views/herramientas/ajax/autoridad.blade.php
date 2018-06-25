{!!Html::style('css/editable_table_style.css')!!}

<h4 style="color: blue;">Autoridad emisora</h4>
<br>
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead>
    <tr class=table_head>
       <th>Id</th>
       <th>nombre</th>       
       <th>Opciones</th> 
     </tr>  
  </thead>
  <tbody>
    @foreach($autoridades as $autoridad)
    <tr>
      <td>{{$autoridad->id}}</td>
      <td contenteditable="true" id="tdtext{{$autoridad->id}}"> {{$autoridad->nombre}} </td>
      <td> <button  title="guardar" onclick="save_register({{$autoridad->id}})"><i class="fa fa-floppy-o" aria-hidden="true"></i> </button> <button title="eliminar" onclick="delete_register({{$autoridad->id}})"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>
    </tr>
    @endforeach
  </tbody>         	
</table>
<button onclick="open_modal()" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Nuevo Autoridad emisora</button>

{{csrf_field()}}

<input type="hidden" name="autoridadid" >

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Nueva autoridad emisora</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group">      
          <label>Nombre de autoridad</label>
            <input  name="new_autoridad" type="text" class="form-control" required>        
        </div>                             
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="new_register()" data-dismiss="modal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Autoridad a reemplazar</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group">      
          <label>Autoridad</label>
            <select name="autoridad_emisora" class="form-control" >
              <option value="placeholder">Selecciona</option>
              @foreach($autoridades as $autoridad)
              <option value="{{$autoridad->id}}">{{$autoridad->nombre}}</option>
              @endforeach
            </select>     
        </div>                             
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="pass_autoridades()" data-dismiss="modal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



<script>

function open_modal()
{  
  $("#myModal").modal("show");      
}

function big_text_edit(elem){
  var id = $(elem).css("white-space","normal");   
}

function big_text_edit_over(elem){
  //console.log("sali");
  var id = $(elem).css("white-space","nowrap");   
}

function save_register(id){

  nombre = $("#tdtext"+id).text();   
  token = $("input[name='_token']").val();
  //console.log("parametros a guardar "+nombre+" parametro "+factor+" token "+token);
  $.post("actualizar_autoridad", { id:id, nombre:nombre , _token:token} ,function(data){
      alert(data);
  });
    
}

function new_register()
{  
  nombre = $("input[name='new_autoridad']").val();   
  token = $("input[name='_token']").val();
  
  $.post("nueva_autoridad", { nombre:nombre, _token:token} ,function(data){      
    if(data=='allow')
    {
      alert("datos guardados");
      autoridad_table();
    }
    else{
      alert("Ya existe una autoridad emisora con estos datos");
    }
  }); 
  
}

function delete_register(id)
{  
  if(confirm("¿Desea reemplazar esta autoridad emisora con otra antes de eliminarla ?") ==  true)
  {
    $("input[name='autoridadid']").val(id);
    $("#myModal2").modal("show");    
  }
  else{
    if(confirm("¿Eliminar esta autoridad emisora eliminara los registros relacionados?") ==  true)
    {
      $.get("eliminar_autoridad/"+id, function(res){
        alert(res);
        autoridad_table();
      });
    }
  }   
}

function pass_autoridades()
{
  id = $("input[name='autoridadid']").val();
  foid = $("select[name='autoridad_emisora']").val();
    $.get("pass_autoridad/"+id+"/"+foid, function(res){
      alert(res);
      autoridad_table();
    });
}

</script> 