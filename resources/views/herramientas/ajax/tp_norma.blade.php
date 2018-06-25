{!!Html::style('css/editable_table_style.css')!!}
<h4 style="color: blue;">Tipo norma</h4>
<br>
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead>
    <tr class="table_head">
       <th>Id</th>
       <th>nombre</th>       
       <th>Opciones</th> 
     </tr>  
  </thead>
  <tbody>
    @foreach($tpnormas as $tpnorma)
    <tr>
      <td>{{$tpnorma->id}}</td>
      <td contenteditable="true" id="tdtext{{$tpnorma->id}}"> {{$tpnorma->nombre}} </td>
      <td><button  title="guardar" onclick="save_register({{$tpnorma->id}})"><i class="fa fa-floppy-o" aria-hidden="true"></i> </button> <button title="eliminar" onclick="delete_register({{$tpnorma->id}})"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>
    </td>
    </tr>
    @endforeach
  </tbody>         	
</table>
<button onclick="open_modal()" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Nuevo Tipo norma</button>

{{csrf_field()}}

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Nuevo Tipo norma </h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group">      
          <label>Nombre de Tipo norma</label>
            <input  name="new_tpnorma" type="text" class="form-control" required>        
        </div>                             
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="new_register()" data-dismiss="modal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- Modal2 -->
<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Reemplazar Tipo norma </h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idtpnorma"/>                      
        <div class="form-group">      
          <label>Tipo norma</label>
            <select name="tpr" id="tpnormasr" class="form-control">
              <option value="placeholder">Selecciona</option>
              @foreach($tpnormas as $tpnorma)
                <option value="{{$tpnorma->id}}">{{$tpnorma->nombre}}</option>
              @endforeach
            </select>        
        </div>                             
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="replace_tpnorma()" data-dismiss="modal">Guardar</button>
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
  $.post("actualizar_tpnorma", { id:id, nombre:nombre , _token:token} ,function(data){
      alert(data);
  });
    
}

function new_register()
{  
  nombre = $("input[name='new_tpnorma']").val();   
  token = $("input[name='_token']").val();
  
  $.post("nuevo_tpnorma", { nombre:nombre, _token:token} ,function(data){      
    if(data=='allow')
    {
      alert("datos guardados");
      tpnorma_table();
    }
    else{
      alert("Ya existe una autoridad emisora con estos datos");
    }
  }); 
  
}

function delete_register(id)
{  
  if(confirm("¿Desea reemplazar este tipo de norma con otro antes de eliminarlo?") ==  true)
  {
    $("input[name='idtpnorma']").val(id);
    $("#myModal2").modal('show');
  }
  else{
    if(confirm("¿Desea eliminar el tipo norma, esto eliminara los registros relacionados?") ==  true)
    {
      $.get("eliminar_tpnorma/"+id, function(res){
      alert(res);
      tpnorma_table();
      });
    }
  }   
}

function replace_tpnorma()
{
  foid = $("input[name='idtpnorma']").val(); 
  id = $('#tpnormasr').val();    
  //return alert("id "+id+"foid "+foid);
    $.get("pass_tpnorma/"+id+"/"+foid, function(res){
      alert(res);
      tpnorma_table();
    });
}    

</script> 