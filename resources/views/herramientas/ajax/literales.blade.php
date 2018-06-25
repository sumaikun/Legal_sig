{!!Html::style('css/editable_table_style.css')!!}
<h4 style="color: blue;">Literales</h4>
<br>
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead>
    <tr class="table_head">
       <th>Id</th>
       <th>Tipo norma</th>    
       <th>Número de la norma</th>
       <th>articulo</th>
       <th>Literal</th>
       <th>Estado</th>
       <th>opciones</th>
     </tr>  
  </thead>
  <tbody>
    @foreach($literales as $literal)
    <tr>
      <td>{{$literal->id}}</td>
      <td>  <span id="paramtext1{{$literal->id}}">{{$literal->tp_norma}}</span></td>
      <td>  <span id="paramtext2{{$literal->id}}">{{$literal->norma}}</span></td>
      <td> <input type="hidden" name ="td_param{{$literal->id}}" value="{{$literal->articuloid}}"> <span id="paramtext3{{$literal->id}}">{{$literal->articulo}}</span> <a href="#" onclick="changue({{$literal->id}})" title="cambiar"><i class="fa fa-pencil" aria-hidden="true"></i></a> </td>
      <td id="tdtext{{$literal->id}}" contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$literal->literal}} </td>
      <td>{{$literal->vigencia}} @if($literal->vigencia=='Derogado')<button onclick="check_der_info3({{$literal->id}})" title="información"><i class="fa fa-eye" aria-hidden="true"></i></button><button  onclick="anular_der({{$literal->id}})" title="revertir derogación"><i class="fa fa-repeat" aria-hidden="true"></i></button>@endif </td>      
      <td>  <button  title="guardar" onclick="save_register({{$literal->id}})"><i class="fa fa-floppy-o" aria-hidden="true"></i> </button> <button title="eliminar" onclick="delete_register({{$literal->id}})"><i class="fa fa-trash" aria-hidden="true"></i></button><button title="derogar" onclick="identify({{$literal->id}})" data-toggle="modal" data-target="#myModal3" @if($literal->vigencia=='Derogado'){{'disabled'}}@endif><i class="fa fa-check" aria-hidden="true"></i></button> </td>
    </tr>
    @endforeach
  </tbody>         	
</table>
<button  onclick="changue('new')" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Nuevo literal</button> 

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Articulos</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group">
          <label class="form-control">Tipo norma</label>
          <select  class="form-control" name="tpnorma" onclick="addnormas(this)" required>
            <option value="">Selecciona</option>                  
              @foreach($tiposnorma as $tiponorma)
              <option value="{{$tiponorma->id}}">{{$tiponorma->nombre}}</option>
              @endforeach              
          </select>
        </div>
        <div class="form-group">
          <label class="form-control">Norma</label>
          <select  name="norma" onclick="addarticulos(this)" class="form-control filter_norma" required>
            <option value="">Selecciona</option>
          </select>
        </div>                       
        <div class="form-group">
          <label class="form-control">Articulo</label>
          <select  name="articulo"  class="form-control filter_articulo" required>
            <option value="">Selecciona</option>
          </select>
        </div>
        <input type="hidden" name="idlit">                     
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
        <h4 class="modal-title">Nuevo literal</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group">
          <label class="form-control">Tipo norma</label>
          <select  class="form-control" name="new_tpnorma" onclick="addnormas(this)" required>
            <option value="">Selecciona</option>                  
              @foreach($tiposnorma as $tiponorma)
              <option value="{{$tiponorma->id}}">{{$tiponorma->nombre}}</option>
              @endforeach              
          </select>
        </div>
        <div class="form-group">
          <label class="form-control">Norma</label>
          <select  name="new_norma" onclick="addarticulos(this)" class="form-control filter_norma" required>
            <option value="">Selecciona</option>
          </select>
        </div>                       
        <div class="form-group">
          <label class="form-control">Articulo</label>
          <select  name="new_articulo"  class="form-control filter_articulo" required>
            <option value="">Selecciona</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-control">Nuevo literal</label>
            <input type="text" class="form-control" name="new_literal">
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
        <h4 class="modal-title">Derogación de literal</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group" >
          <input list="literales" class="form-control" name="browser">
            <datalist id="literales">
              @foreach($literales as $literal)
                <option data-value="{{$literal->id}}" value="{{$literal->tp_norma}} {{$literal->norma}} del año {{$literal->emision}} articulo {{$literal->articulo}} literal {{$literal->literal}} id: {{$literal->id}}">
                  {{$literal->id}}
                </option>
              @endforeach
            </datalist>
        </div>                       
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="derogar()" data-dismiss="modal">derogar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




{{csrf_field()}}
<input type="hidden" name="idlit" value="">

<script>

function identify(id)
{
  $("input[name='idlit']").val(id);
}

function anular_der(id)
{
  if(confirm("¿Desea anular la derogación del literal?") ==  true)
  {
    $.get("anular_derogar_literal/"+id, function(res){
        alert(res);
        literales_table();
      });
  }    
}

function check_der_info3(id)
{
  $.get("derogar_info_3/"+id, function(res){
      alert(res);      
    });
}

function addnormas(element){
  if($(element).val()!="")
  {
   $.get(`filternormas/`+$(element).val(), function(res){              
      $(".filter_norma").empty();
      $(".filter_norma").append(`<option value="">Selecciona</option>`);          
        res.forEach(element => {
        $(".filter_norma").append(`<option value=${element.id}> ${element.numero} </option>`);
      });
    });   
  }  
}

function derogar()
{
   var id = $("input[name='idlit']").val();
   var value = $('input[name="browser"]').val();
   var foid = $('#articulos [value="'+value+'"]').data('value');
   
   $.get("derogar_literal/"+foid+"/"+id, function(res){
      alert(res);
      literales_table();
    });
   
}

 function addarticulos(element)
{
  if($(element).val()!="")
  {
    $.get(`filterarticulos/`+$(element).val(), function(res){              
      $(".filter_articulo").empty();
      $(".filter_articulo").append(`<option value="">Selecciona</option>`);  
          res.forEach(element => {
          $(".filter_articulo").append(`<option value=${element.id}> ${element.numero} </option>`);
      });
    });
  }  
}

function changue(id)
{  
  if(id=="new")
  {
    $("#myModal2").modal("show");
  }
  else
  {
   $("#myModal").modal("show"); 
   $("input[name='idlit']").val(id); 
  }
  
}

function changue_param()
{
  if($("select[name='tpnorma']").val() != "" && $("select[name='norma']").val() != "" && $("select[name='articulo']").val() != "")
  {
    id = $("input[name='idlit']").val();        
    paramval = $("select[name='tpnorma']").val();
    $("#paramtext1"+id).text($("select[name='tpnorma'] option[value="+paramval+"]").text());
    paramval = $("select[name='norma']").val();
    $("#paramtext2"+id).text($("select[name='norma'] option[value="+paramval+"]").text());
    paramval = $("select[name='articulo']").val();
    $("input[name='td_param"+id+"']").val(paramval);
    $("#paramtext3"+id).text($("select[name='articulo'] option[value="+paramval+"]").text());    
  }

}

function big_text_edit(elem){
  var id = $(elem).css("white-space","normal");   
}

function big_text_edit_over(elem){
  //console.log("sali");
  var id = $(elem).css("white-space","nowrap");   
}

function save_register(id){
  numero = $("#tdtext"+id).text(); 
  articulo = $("input[name=td_param"+id+"").val();
  token = $("input[name='_token']").val();
  $.post("actualizar_literal", { id:id, numero:numero, articulo:articulo, _token:token} ,function(data){
      alert(data);
  });
    
}

function new_register()
{  
  articulo = $("select[name='new_articulo']").val(); 
  numero = $("input[name='new_literal'").val();
  token = $("input[name='_token']").val();
  if(articulo != "" && numero != "")
  {
    $.post("nuevo_literal", { numero:numero, articulo:articulo, _token:token} ,function(data){      
      if(data=='allow')
      {
        alert("datos guardados");
        literales_table();
      }
      else{
        alert("ya existe un literal con los mismos datos");
      }
    });  
  }
  
}

function delete_register(id)
{  
  if(confirm("¿Esta seguro, esto eliminara todos los registros que tengan este literal?") ==  true)
  {
    $.get("eliminar_literal/"+id, function(res){
      alert(res);
      literales_table();
    });
  }
   
}

    


</script>