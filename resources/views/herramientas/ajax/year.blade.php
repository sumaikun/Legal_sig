{!!Html::style('css/editable_table_style.css')!!}
<h4 style="color: blue;">Año de emisión</h4>
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
    @foreach($years as $year)
    <tr>
      <td>{{$year->id}}</td>
      <td contenteditable="true" id="tdtext{{$year->id}}"> {{$year->year}}</span> </td>
      <td> <button  title="guardar" onclick="save_register({{$year->id}})"><i class="fa fa-floppy-o" aria-hidden="true"></i> </button> <button title="eliminar" onclick="delete_register({{$year->id}})"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>
    </tr>
    @endforeach
  </tbody>         	
</table>
<button onclick="open_modal()" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Nuevo Año de emisión</button> 

{{csrf_field()}}

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Nuevo año de emisión</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group">      
          <label>Año</label>
            <input  name="new_year" type="number" min = "1950"  max="2050" class="form-control" required>        
        </div>                             
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="new_register()" data-dismiss="modal">Guardar</button>
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

  year = $("#tdtext"+id).text();   
  token = $("input[name='_token']").val();
  //console.log("parametros a guardar "+nombre+" parametro "+factor+" token "+token);
  $.post("actualizar_year", { id:id, year:year , _token:token} ,function(data){
      alert(data);
  });
    
}

function new_register()
{  
  year = $("input[name='new_year']").val();   
  token = $("input[name='_token']").val();
  if(year >= 1950 &&  year <= 2050)
  {
    $.post("nuevo_year", { year:year, _token:token} ,function(data){      
      if(data=='allow')
      {
        alert("datos guardados");
        year_table();
      }
      else{
        alert("Ya existe un año de emisión con estos datos");
      }
    });  
  }
  else{
    alert("el valor ingresado para año de emision no es valido");
    $("input[name='new_year']").val(0);
  }
  
}

function delete_register(id)
{  
  if(confirm("¿Esta seguro, esto eliminara todos los registros que tengan este año de emisión?") ==  true)
  {
    $.get("eliminar_year/"+id, function(res){
      alert(res);
      year_table();
    });
  }
   
}

    


</script> 