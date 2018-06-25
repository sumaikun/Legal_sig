{!!Html::style('css/editable_table_style.css')!!}
<h4 style="color: blue;">Normas</h4>
<br>
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead>
    <tr class="table_head">
       <th>Id</th>
       <th>Tipo norma</th>    
       <th>Autoridad emisora</th> 
       <th>Año de emisión</th>
       <th>Número de la norma</th>
       <th>Estado</th>
       <th>opciones</th>
     </tr>  
  </thead>
  <tbody>
    @foreach($normas as $norma)
    <tr>
      <td>{{$norma->id}}</td>
      <td onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> <input type="hidden" id ="td_param1{{$norma->id}}" value="{{$norma->tp_norma->id}}"> <span id="paramtext1{{$norma->id}}">{{$norma->tp_norma->nombre}}</span> <a href="#" onclick="changue({{$norma->id}})" title="cambiar"><i class="fa fa-pencil" aria-hidden="true"></i></a> </td>
      <td onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> <input type="hidden" id ="td_param2{{$norma->id}}" value="{{$norma->autoridad->id}}"> <span id="paramtext2{{$norma->id}}">{{$norma->autoridad->nombre}}</span> <a href="#" onclick="changue2({{$norma->id}})" title="cambiar"><i class="fa fa-pencil" aria-hidden="true"></i></a> </td>
      <td> <input type="hidden" id ="td_param3{{$norma->id}}" value="{{$norma->emision->id}}"> <span id="paramtext3{{$norma->id}}">{{$norma->emision->year}}</span> <a href="#" onclick="changue3({{$norma->id}})" title="cambiar"><i class="fa fa-pencil" aria-hidden="true"></i></a> </td>
      <td id="tdtext{{$norma->id}}" contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$norma->numero}} </td>
      <td>{{$norma->estado->nombre}}@if($norma->estado->nombre=='Derogado')<button  onclick="check_der_info({{$norma->id}})" title="información"><i class="fa fa-eye" aria-hidden="true"></i></button><button  onclick="anular_der({{$norma->id}})" title="revertir derogación"><i class="fa fa-repeat" aria-hidden="true"></i></button>@endif</td>
      <td> <button  title="guardar" onclick="save_register({{$norma->id}})"><i class="fa fa-floppy-o" aria-hidden="true"></i> </button> <button title="eliminar" onclick="delete_register({{$norma->id}})"><i class="fa fa-trash" aria-hidden="true"></i></button> <button title="derogar" onclick="identify({{$norma->id}})" data-toggle="modal" data-target="#myModal5" @if($norma->estado->nombre=='Derogado'){{'disabled'}}@endif><i class="fa fa-check" aria-hidden="true"></i></button></td>
    </tr>
    @endforeach
  </tbody>         	
</table>
<button onclick="new_reg()" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Nueva norma</button> 

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tipo norma</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group">
          <label class="form-control">Tipo norma</label>
          <select  class="form-control" name="tpnorma"  required>
            <option value="">Selecciona</option>                  
              @foreach($tiposnorma as $tiponorma)
              <option value="{{$tiponorma->id}}">{{$tiponorma->nombre}}</option>
              @endforeach              
          </select>
        </div>                          
                             
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="changue_param1()" data-dismiss="modal">Cambiar</button>
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
        <h4 class="modal-title">Autoridad</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group" >
            {!!Form::label('Autoridad que Emite')!!}
            <select name="autoridad" class="form-control">
              <option value="placeholder">Selecciona</option>
              @foreach($autoridades as $autoridad)
              <option value="{{$autoridad->id}}">{{$autoridad->nombre}}</option>
              @endforeach
            </select>
         </div>                          
                             
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="changue_param2()" data-dismiss="modal">Cambiar</button>
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
        <h4 class="modal-title">Año de emisión</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group" >
            {!!Form::label('Año de Emisión')!!}
            <select name="year" class="form-control" >
              <option value="placeholder">Selecciona</option>
              @foreach($years as $year)
              <option value="{{$year->id}}">{{$year->year}}</option>
              @endforeach
            </select>
        </div>                          
                             
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="changue_param3()" data-dismiss="modal">Cambiar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="myModal4" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Nueva Norma</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group">
          <label class="form-control">Tipo norma</label>
          <select  class="form-control" name="new_tpnorma"  required>
            <option value="">Selecciona</option>                  
              @foreach($tiposnorma as $tiponorma)
              <option value="{{$tiponorma->id}}">{{$tiponorma->nombre}}</option>
              @endforeach              
          </select>
        </div>
        <div class="form-group" >
            {!!Form::label('Año de Emisión')!!}
            <select name="new_year" class="form-control">
              <option value="placeholder">Selecciona</option>
              @foreach($years as $year)
              <option value="{{$year->id}}">{{$year->year}}</option>
              @endforeach
            </select>
        </div>
        <div class="form-group" >
            {!!Form::label('Autoridad que Emite')!!}
            <select id="new_autoridad" name="new_autoridad" class="form-control" >
              <option value="placeholder">Selecciona</option>
              @foreach($autoridades as $autoridad)
              <option value="{{$autoridad->id}}">{{$autoridad->nombre}}</option>
              @endforeach
            </select>
         </div>                       
        <div class="form-group">
          <label class="form-control">Nueva Norma</label>
            <input type="text" class="form-control" name="new_norma">
        </div>                                     
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="new_register()" data-dismiss="modal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<div id="myModal5" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Derogación de norma</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group" >
            <input list="normas" class="form-control" name="browser">
            <datalist id="normas">
              @foreach($normas as $norma)
                <option data-value="{{$norma->id}}" value="{{$norma->tp_norma->nombre}} {{$norma->numero}} año {{$norma->emision->year}}">
                  {{$norma->id}}
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

<div id="myModal6" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reemplazar Norma</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group" >
            <input list="normas" class="form-control" name="norlist">
            <datalist id="normasr">
              @foreach($normas as $norma)
                <option data-value="{{$norma->id}}" value="{{$norma->tp_norma->nombre}} {{$norma->numero}} año {{$norma->emision->year}}">
                  {{$norma->id}}
                </option>
              @endforeach
            </datalist>
        </div>                       
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="reemplazar()" data-dismiss="modal">Reemplazar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



{{csrf_field()}}
<input type="hidden" name="idnor" value="">
<script>

function check_der_info(id)
{
  $.get("derogar_info/"+id, function(res){
      alert(res);      
    });
}

function identify(id)
{
  $("input[name='idnor']").val(id); 
}

function derogar()
{
   var id = $("input[name='idnor']").val();
   var value = $('input[name="browser"]').val();
   var foid = $('#normas [value="'+value+'"]').data('value');
   $.get("derogar_norma/"+foid+"/"+id, function(res){
      alert(res);
      normas_table();
    });
   
}

function reemplazar()
{
   var id = $("input[name='idnor']").val();
   var value = $('input[name="norlist"]').val();
   var foid = $('#normasr [value="'+value+'"]').data('value');
   $.get("reemplazar_norma/"+foid+"/"+id, function(res){
      alert(res);
      normas_table();
    });
}

function anular_der(id)
{
  if(confirm("¿Desea anular la derogación de la norma?") ==  true)
  {
    $.get("anular_derogar_norma/"+id, function(res){
        alert(res);
        normas_table();
      });
  }    
}

function changue(id)
{  
  $("#myModal").modal('show');
  $("input[name='idnor']").val(id);  
}

function changue2(id)
{ 
  $("#myModal2").modal('show');
  $("input[name='idnor']").val(id); 
}

function changue3(id)
{  
  $("#myModal3").modal('show');
  $("input[name='idnor']").val(id); 
}

function new_reg()
{
  $("#myModal4").modal('show'); 
}

function changue_param1()
{  
   if($("select[name='tpnorma']").val() != "")
   {
      id = $("input[name='idnor']").val();        
      paramval = $("select[name='tpnorma']").val();
      $("#paramtext1"+id).text($("select[name='tpnorma'] option[value="+paramval+"]").text());
      $("#td_param1"+id).val(paramval);
   }
}

function changue_param2()
{  
   if($("select[name='autoridad']").val() != "")
   {
      id = $("input[name='idnor']").val();        
      paramval = $("select[name='autoridad']").val();
      $("#paramtext2"+id).text($("select[name='autoridad'] option[value="+paramval+"]").text());
      $("#td_param2"+id).val(paramval);
   }
}

function changue_param3()
{  
   if($("select[name='year']").val() != "")
   {
      id = $("input[name='idnor']").val();        
      paramval = $("select[name='year']").val();
      $("#paramtext3"+id).text($("select[name='year'] option[value="+paramval+"]").text());
      $("#td_param3"+id).val(paramval);
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
  tiponorma = $("#td_param1"+id).val();
  autoridad = $("#td_param2"+id).val();
  year = $("#td_param3"+id).val();
  token = $("input[name='_token']").val();
  $.post("actualizar_norma", { id:id, numero:numero, tiponorma:tiponorma, autoridad:autoridad, year:year, _token:token} ,function(data){
      alert(data);
  });
    
}

function new_register()
{  
  tiponorma = $("select[name='new_tpnorma']").val(); 
  autoridad = $("#new_autoridad").val();
  year = $("select[name='new_year']").val();
  numero = $("input[name='new_norma'").val();
  token = $("input[name='_token']").val();
  if(tiponorma != "" && numero != "" && year != "" && autoridad != "")
  {    
    $.post("nueva_norma", { numero:numero, tiponorma:tiponorma, autoridad:autoridad, year:year, _token:token} ,function(data){      
      if(data=='allow')
      {
        alert("datos guardados");
        normas_table();
      }
      else{
        alert("ya existe una norma con estos datos");
      }
    });  
  }
  
}

function delete_register(id)
{  
  if(confirm("¿Desea reemplazar los registros con otra norma antes de eliminarla?") ==  true)
  {
    $("input[name='idnor']").val(id); 
    $("#myModal6").modal('show');
  }
  else{
    if(confirm("¿Desea reemplazar los registros con otra norma antes de reemplazarla?") ==  true)
    {
      $.get("eliminar_norma/"+id, function(res){
        alert(res);
        normas_table();
      });
    }
  }
   
}

    


</script>