{!!Html::style('css/editable_table_style.css')!!}
<h4 style="color: blue;">Artículos</h4>
<br>

<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead>
    <tr class="table_head">
       <th>Id</th>
       <th>Tipo norma</th>    
       <th>Número <br>de la norma</th>
       <th>Autoridad<br>Emisora</th>
       <th>Año de <br> Emisión</th>
       <th>articulo</th>
       <th>estado</th>
       <th>opciones</th>
     </tr>  
  </thead>
  <tbody>
    @foreach($articulos as $articulo)
    <tr>
      <td>{{$articulo->id}}</td>
      <td> <span id="paramtext1{{$articulo->id}}">{{$articulo->tp_norma}}</span> </td>
      <td> <input type="hidden" name ="td_param{{$articulo->id}}" value="{{$articulo->normaid}}"> <span id="paramtext2{{$articulo->id}}">{{$articulo->norma}}</span> <a href="#" onclick="changue({{$articulo->id}})" title="cambiar"><i class="fa fa-pencil" aria-hidden="true"></i></a> </td>
      <td onclick="big_text_edit(this)" id="autoridad{{$articulo->id}}">{{$articulo->autoridad}}</td>
      <td id="Emision{{$articulo->id}}" >{{$articulo->emision}}</td>
      <td id="tdtext{{$articulo->id}}" contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$articulo->articulo}} </td>
      <td> {{$articulo->vigencia}} @if($articulo->vigencia=='Derogado')<button  onclick="check_der_info2({{$articulo->id}})" title="información"><i class="fa fa-eye" aria-hidden="true"></i></button><button  onclick="anular_der({{$articulo->id}})" title="revertir derogación"><i class="fa fa-repeat" aria-hidden="true"></i></button>@endif </td>      
      <td> <button  title="guardar" onclick="save_register({{$articulo->id}})"><i class="fa fa-floppy-o" aria-hidden="true"></i> </button> <button title="eliminar" onclick="delete_register({{$articulo->id}})"><i class="fa fa-trash" aria-hidden="true"></i></button> <button title="derogar" onclick="identify({{$articulo->id}})" data-toggle="modal" data-target="#myModal3" @if($articulo->vigencia=='Derogado'){{'disabled'}}@endif><i class="fa fa-check" aria-hidden="true"></i></button></td>
    </tr>
    @endforeach
  </tbody>         	
</table>

<button onclick="changue('new')" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Nuevo artículo</button> 

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cambio de norma</h4>
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
          <select  name="norma"  class="form-control filter_norma" required>
            <option value="">Selecciona</option>
          </select>
        </div>                       
        <input type="hidden" name="idnor">                     
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
        <h4 class="modal-title">Nuevo Articulo</h4>
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
          <select  name="new_norma"  class="form-control filter_norma" required>
            <option value="">Selecciona</option>
          </select>
        </div>                       
        <div class="form-group">
          <label class="form-control">Nuevo Articulo</label>
            <input type="text" class="form-control" name="new_articulo">
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
        <h4 class="modal-title">Derogación de artículo</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group" >
          <input list="articuloslist" class="form-control" name="browser">
            <datalist id="articuloslist">
              @foreach($articulos as $articulo)
                <option data-value="{{$articulo->id}}" value="{{$articulo->tp_norma}} {{$articulo->norma}} del año {{$articulo->emision}} articulo {{$articulo->articulo}}">
                  {{$articulo->id}}
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
<input type="hidden" name="idar" value="">


<div id="myModal6" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reemplazar Articulo</h4>
      </div>
      <div class="modal-body">                      
        <div class="form-group" >
            <input list="articulosl" class="form-control" name="articulosnum">
            <datalist id="articulosl">
              @foreach($articulos as $articulo)
                <?php $norma = Sig\Models\Normas::where('id','=',$articulo->normaid)->first(); ?>
                <option data-value="{{$articulo->id}}" value="{{$norma->tp_norma->nombre}} {{$norma->numero}} articulo {{$articulo->articulo}} id {{$articulo->id}}">
                  {{$articulo->id}}
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

<input name="idart" type="hidden">

<script>

function check_der_info2(id)
{
  $.get("derogar_info_2/"+id, function(res){
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
   var id = $("input[name='idar']").val();
   var value = $('input[name="browser"]').val();
   var foid = $('#articulos [value="'+value+'"]').data('value');
   $.get("derogar_articulo/"+foid+"/"+id, function(res){
      alert(res);
      articulos_table();
    });
   
}

function anular_der(id)
{
  if(confirm("¿Desea anular la derogación del articulo?") ==  true)
  {
    $.get("anular_derogar_articulo/"+id, function(res){
        alert(res);
        articulos_table();
      });
  }    
}


function identify(id)
{
  $("input[name='idar']").val(id); 
}

function changue(id)
{  
  if(id=="new")
  {
    $("#myModal2").modal("show");
  }
  else{
   $("#myModal").modal("show"); 
   $("input[name='idnor']").val(id); 
  }
  
}

function changue_param()
{
  if($("select[name='tpnorma']").val() != "" && $("select[name='norma']").val() != "" )
  {
    id = $("input[name='idnor']").val();        
    paramval = $("select[name='tpnorma']").val();
    $("#paramtext1"+id).text($("select[name='tpnorma'] option[value="+paramval+"]").text());
    paramval = $("select[name='norma']").val();
    $("#paramtext2"+id).text($("select[name='norma'] option[value="+paramval+"]").text());
    $("input[name='td_param"+id+"']").val(paramval);
       token = $("input[name='_token']").val();
      $.post("get_emision_and_autority",{norma:$("select[name='norma']").val(),_token:token},function(res){
         $("#autoridad"+id).text(res[0].nombre);
         $("#Emision"+id).text(res[0].year);
      });
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
  norma = $("input[name=td_param"+id+"").val();
  token = $("input[name='_token']").val();
  $.post("actualizar_articulo", { id:id, numero:numero, norma:norma, _token:token} ,function(data){
      alert(data);
  });
    
}

function new_register()
{  
  norma = $("select[name='new_norma']").val(); 
  numero = $("input[name='new_articulo'").val();
  token = $("input[name='_token']").val();
  if(norma != "" && numero != "")
  {
    $.post("nuevo_articulo", { numero:numero, norma:norma, _token:token} ,function(data){      
      if(data=='allow')
      {
        alert("datos guardados");
        articulos_table();
      }
      else{
        alert("ya existe un literal con los mismos datos");
      }
    });  
  }
  
}

function delete_register(id)
{  
    if(confirm("¿Desea reemplazar los requisitos con otro articulo antes de eliminarlo?") ==  true)
  {
    $("input[name='idart']").val(id); 
    $("#myModal6").modal('show');
  }
  else{
    if(confirm("¿Esta seguro, esto eliminara todos los registros que tengan este artículo ?") ==  true)
    {
      $.get("eliminar_articulo/"+id, function(res){
        alert(res);
        articulos_table();
      });
    }
   }
}

function reemplazar()
{
   var id = $("input[name='idart']").val();
   var value = $('input[name="articulosnum"]').val();
   //alert(value);
   var foid = $('#articulosl [value="'+value+'"]').data('value');
   $.get("reemplazar_articulo/"+foid+"/"+id, function(res){
      alert(res);
      articulos_table();
    });
}


</script>