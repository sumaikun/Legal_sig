{!!Html::style('css/editable_table_style.css')!!}
<h4 style="color: blue;">Factores - Aspectos</h4>
<br>
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead>
    <tr class="table_head">
       <th>Id</th>
       <th>Tipo matriz</th>
       <th>Factor</th>       
       <th>Opciones</th> 
     </tr>  
  </thead>
  <tbody>
    @foreach($factores as $factor)
    <tr>
      <td>{{$factor->id}}</td>
      <td> <input type="hidden" name ="td{{$factor->id}}" value="{{$factor->tipo->id}}" > <span id="paramtext{{$factor->id}}">{{$factor->tipo->nombre}}</span>  <a href="#" onclick="changue({{$factor->id}})" title="cambiar"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
      <td id="tdtext{{$factor->id}}" contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$factor->nombre}}  </td>
      <td> <button  title="guardar" onclick="save_register({{$factor->id}})"><i class="fa fa-floppy-o" aria-hidden="true"></i> </button> <button title="eliminar" onclick="delete_register({{$factor->id}})"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>
    </tr>
    @endforeach
  </tbody>         	
</table>
<button onclick="changue('new')" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Nuevo Factor/aspecto</button>

<input type="hidden" name="factorid" >

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tipo de matriz</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group">      
          <label>Tipo de matriz</label>
            <select  name="tpm"  id="tpmedit" class="form-control tipo_matriz" required>
            <option value="">Selecciona</option>
            @foreach($tipos as $key => $temp)
              <option value="{{$key}}">{{$temp}}</option>
            @endforeach                                        
           </select>        
        </div>
        <input type="hidden" name="idfac">                     
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="changue_param()" data-dismiss="modal">Cambiar</button>
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
        <h4 class="modal-title">Nuevo Factores/ Aspectos</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group">      
          <label>Tipo de matriz</label>
            <select  name="new_tpm"  class="form-control tipo_matriz" required>
            <option value="">Selecciona</option>
            @foreach($tipos as $key => $temp)
              <option value="{{$key}}">{{$temp}}</option>
            @endforeach                                        
           </select>        
        </div>        
        <div class="form-group">      
          <label>Nombre del factor o aspecto</label>
            <input type="text" name="new_factor" class="form-control" required>                                        
        </div>                             
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="new_register()" data-dismiss="modal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<div id="myModal3" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Factor a reemplazar</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group" >
          <input list="factores" class="form-control" name="browser">
            <datalist id="factores">
              @foreach($factores as $factor)
                <option data-value="{{$factor->id}}" value="{{$factor->tipo->nombre}}, {{$factor->nombre}}">
                  {{$factor->id}}
                </option>
              @endforeach
            </datalist>
        </div>                                      
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="pass_factores()" data-dismiss="modal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


{{csrf_field()}}

<script>

function changue(id)
{  
  if(id=="new")
  {
    $("#myModal2").modal("show");
  }
  else{
   $("#myModal").modal("show"); 
   $("input[name='idfac']").val(id); 
  }
  
}

function changue_param()
{
  id = $("input[name='idfac']").val();
  if(!$("input[name=td"+id+"").val()=="")
  {    
    paramval = $("#tpmedit").val();
    $("input[name=td"+id+"").val(paramval);  
    $("#paramtext"+id).text($("#tpmedit option[value="+paramval+"]").text());    
  }
  //console.log("encontrado "+$("#factores").val());
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
  tipo = $("input[name=td"+id+"").val();
  token = $("input[name='_token']").val();
  //console.log("parametros a guardar "+nombre+" parametro "+factor+" token "+token);
  $.post("actualizar_factor", { id:id, nombre:nombre, tipo:tipo, _token:token} ,function(data){
      alert(data);
  });
    
}

function new_register()
{  
  nombre = $("input[name='new_factor']").val(); 
  tipo = $("select[name='new_tpm'").val();
  token = $("input[name='_token']").val();
  if(nombre != "" && tipo != "")
  {
    $.post("nuevo_factor", { nombre:nombre, tipo:tipo , _token:token} ,function(data){
      
      if(data=='allow')
      {
        alert("datos guardados");
        factores_table();
      }
      else{
        alert("ya existe un factor con los mismos datos");
      }
    });  
  }
  
}

function delete_register(id)
{  
  if(confirm("¿Desea reemplazar este factor con otro antes de eliminarlo ?") ==  true)
  {
    $("input[name='factorid']").val(id);
    $("#myModal3").modal("show");  
  }
  else{
    if(confirm("¿Desea eliminar este factor esto eliminara los registros relacionados ?") ==  true)
    {
      $.get("eliminar_factor/"+id, function(res){
        alert(res);
        factores_table();
      });
    }  
  }
   
}

function pass_factores()
{
  id = $("input[name='factorid']").val();
  var value = $('input[name="browser"]').val();
  var foid = $('#factores [value="'+value+'"]').data('value');    
  //return alert("id "+id+"foid "+foid);
    $.get("pass_factor/"+id+"/"+foid, function(res){
      alert(res);
      factores_table();
    });
}

    


</script> 