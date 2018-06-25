{!!Html::style('css/editable_table_style.css')!!}

<h4 style="color: blue;">Categorias</h4>
<br>
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead>
    <tr class="table_head">
       <th>Id</th> 
       <th>Factor</th>
       <th>Categorias</th>       
       <th>Opciones</th> 
     </tr>  
  </thead>
  <tbody>
    @foreach($categorias as $categoria)
    <tr>
      <td>{{$categoria->id}}</td>
      <td> <input type="hidden" name ="td{{$categoria->id}}" value="{{$categoria->factor->id}}" > <span id="paramtext{{$categoria->id}}">{{$categoria->factor->nombre}}</span>  <a href="#" onclick="changue({{$categoria->id}})" title="cambiar"><i class="fa fa-pencil" aria-hidden="true"></i></a> </td>
      <td id="tdtext{{$categoria->id}}" contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$categoria->nombre}} </td>
      <td> <button  title="guardar" onclick="save_register({{$categoria->id}})"><i class="fa fa-floppy-o" aria-hidden="true"></i> </button> <button title="eliminar" onclick="delete_register({{$categoria->id}})"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>
    </tr>
    @endforeach
  </tbody>         	
</table>
<button onclick="changue('new')" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Nueva Categoria</button> 

<input type="hidden" name="categoriaid" >

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Factores/ Aspectos</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group">      
          <label>Tipo de matriz</label>
            <select  name="tpm"   class="form-control tipo_matriz" required>
            <option value="">Selecciona</option>
            @foreach($tipos as $key => $temp)
              <option value="{{$key}}">{{$temp}}</option>
            @endforeach                                        
           </select>        
        </div>
        <div class="form-group">      
          <label>Seleccione el factor</label>
            <select  name="factor" id="factoredit" class="form-control factores" required>
            <option value="">Selecciona</option>                                        
          </select>        
        </div>
        <input type="hidden" name="idcat">                     
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
        <h4 class="modal-title">Nueva categoria</h4>
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
          <label>Seleccione el factor</label>
            <select  name="new_factor"  class="form-control factores" required>
            <option value="">Selecciona</option>                                        
          </select>        
        </div>
        <div class="form-group">      
          <label>Nombre categoria</label>
            <input type="text" name="new_categoria" class="form-control" required>                                        
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
        <h4 class="modal-title">Categoria a reemplazar</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group" >
          <input list="categorias" class="form-control" name="browser">
            <datalist id="categorias">
              @foreach($categorias as $categoria)
                <option data-value="{{$categoria->id}}" value="{{$categoria->factor->nombre}}, {{$categoria->nombre}}">
                  {{$categoria->id}}
                </option>
              @endforeach
            </datalist>
        </div>                                      
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="pass_categorias()" data-dismiss="modal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


{{csrf_field()}}

<script>

  $(".tipo_matriz").change(event => {
    $.get(`filterfactores`+`/${event.target.value}`, function(res){
          $(".factores").empty();
          $(".factores").append(`<option value="">Selecciona</option>`);
          res.forEach(element => {
            $(".factores").append(`<option value=${element.id}> ${element.nombre} </option>`);
          });
        });
    });

function changue(id)
{  
  if(id=="new")
  {
    $("#myModal2").modal("show");
  }
  else{
   $("#myModal").modal("show"); 
   $("input[name='idcat']").val(id); 
  }
  
}

function changue_param()
{
    id = $("input[name='idcat']").val();
  if(!$("input[name=td"+id+"").val()=="")
  {  
    paramval = $("#factoredit").val();
    $("input[name=td"+id+"").val(paramval);  
    $("#paramtext"+id).text($("#factoredit option[value="+paramval+"]").text());    
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
  factor = $("input[name=td"+id+"").val();
  token = $("input[name='_token']").val();
  //console.log("parametros a guardar "+nombre+" parametro "+factor+" token "+token);
  $.post("actualizar_categoria", { id:id, nombre:nombre, factor:factor, _token:token} ,function(data){
      alert(data);
  });
    
}

function new_register()
{  
  nombre = $("input[name='new_categoria']").val(); 
  factor = $("select[name='new_factor'").val();
  token = $("input[name='_token']").val();
  if(nombre != "" && factor != "")
  {
    $.post("nueva_categoria", { nombre:nombre, factor:factor, _token:token} ,function(data){      
      if(data=='allow')
      {
        alert("datos guardados");
        categorias_table();
      }
      else{
        alert("ya existe una categoría con los mismos datos");
      }
    });  
  }
  
}

function delete_register(id)
{  
  if(confirm("¿Desea reemplazar esta categoria con otra antes de eliminarla ?") ==  true)
  {
    $("input[name='categoriaid']").val(id);
    $("#myModal3").modal("show");  
  }
  else
  {
    if(confirm("¿Eliminar esta categoria eliminara todos los registros relacionados, Desea continuar ?") ==  true)
    {
      $.get("eliminar_categoria/"+id, function(res){
        alert(res);
        categorias_table();
      });
    }  
  }
   
}

function pass_categorias()
{
  id = $("input[name='categoriaid']").val();
  var value = $('input[name="browser"]').val();
  var foid = $('#categorias [value="'+value+'"]').data('value');    
  //return alert("id "+id+"foid "+foid);
    $.get("pass_categoria/"+id+"/"+foid, function(res){
      alert(res);
      categorias_table();
    });
}
  


</script>