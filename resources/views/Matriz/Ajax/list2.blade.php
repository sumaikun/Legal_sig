{!!Html::style('css/editable_table_style.css')!!}
<table id="example"  style="font-size: 75%;" class="table">
  <thead>
   <tr>
      <th>Tipo</th>
      <th>Empresas</th>                  
      <th>Tipo Norma</th>                                   
      <th>Emisión</th>
      <th>Norma</th> 
      <th>Articulo</th>
      <th>Literal</th> 
      <th>Descripcion</th>                        
      <th>Fecha</th>
      <th>btn</th>                  
  </tr>
</thead>
  <tbody>
  @foreach($requisitos as $requisito)
  <tr>
    <td id="fx_tipo{{$requisito->id}}" contenteditable="false" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->tipo_matriz}} </td>
    <td onclick="big_text_edit(this)" onblur="big_text_edit_over(this)" id="fx_empresas{{$requisito->id}}"> {{Sig\Helpers\Externclass::enterprise_name($requisito->empresa)}} </td>                    
    <td id="fx_tpnorma{{$requisito->id}}"  contenteditable="false" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)" ><input type="hidden" id ="td_param1{{$requisito->id}}" value="{{$requisito->tipo_norma}}"> <span id="paramtext1{{$requisito->id}}">{{$requisito->tipo_norma}}</span> <a href="#" onclick="changue({{$requisito->id}})" title="cambiar"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
    <td id="fx_emision{{$requisito->id}}"  contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->emision}}</td>
    <td id="fx_norma{{$requisito->id}}"  contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->norma}}</td>
    <td id="fx_articulo{{$requisito->id}}" contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->articulo}} </td>
    <td id="fx_literal{{$requisito->id}}" contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->litnum}} </td> 
    <td contenteditable="false" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{Sig\Helpers\Externclass::error_transcripter((string)$requisito->description)}} </td> 
    <td contenteditable="false" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->created_at}} </td>
    <td><button  title="info extra" data-toggle="modal" data-target="#myModal" onclick="addinfoextra('{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->descnorma)}}','{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->nrelacionadas)}}','{{$requisito->id}}','{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->factor)}}','{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->categoria)}}')"><i class="fa fa-cog" aria-hidden="true"></i></button>
      @if(Auth::user()->rol_id!=3)<button  onclick="manual_fixing({{$requisito->id}})" title="Arreglar" ><i class="fa fa-floppy-o" aria-hidden="true" aria-hidden="true"></i></button> <button title="Quick fix" href="#"><i class="fa fa-fast-forward" aria-hidden="true"></i></button>
      <button title="eliminar" onclick="delete_register({{$requisito->id}})"><i class="fa fa-trash" aria-hidden="true"></i></button>@endif</td>

      
  </tr>
@endforeach        
</tbody>
<tfoot>
<tr>
      <th>Tipo</th>
      <th>Empresas</th>             
      <th>Tipo norma</th>
      <th>Emisión</th>                                                    
      <th>Norma</th> 
      <th>Articulo</th>
      <th>Literal</th> 
      <th>Descripcion</th>                        
      <th>Fecha</th>
      <th>Total {{count($requisitos)}}</th>                 
  </tr>
  </tfoot>
</table>

{{csrf_field()}}


<div id="myModals" class="modal fade" role="dialog">
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

<input type="hidden" name="idrequisito" value="">
<script>

    function changue(id)
    {  
      $("#myModals").modal('show');
      $("input[name='idrequisito']").val(id);  
    }

    function changue_param1()
    {  
       if($("select[name='tpnorma']").val() != "")
       {
          id = $("input[name='idrequisito']").val();        
          paramval = $("select[name='tpnorma']").val();
          texto = $("select[name='tpnorma'] option[value="+paramval+"]").text();
          $("#paramtext1"+id).text(texto);
          $("#td_param1"+id).val(paramval);
          token = $("input[name='_token']").val();
          $.post("change_fixreq_tpnorma", { tp_norma:texto , id:id, _token:token} ,function(data){        
            alert(data);
        }); 
       }
    }

    function manual_fixing(id){
        norma = $("#fx_norma"+id).text();
        console.log('norma '+norma);
        articulo = $("#fx_articulo"+id).text();
        literal = $("#fx_literal"+id).text();
        emision = $("#fx_emision"+id).text();
        token = $("input[name='_token']").val();
        $.post("manual_fixing", { norma:norma, articulo:articulo, literal:literal, emision:emision, area:area, id:id, _token:'{{ csrf_token() }}'} ,function(data){      
          if(data=='requisito arreglado')
          {
             filter_upload();
          }
          alert(data);
        });  
     }
     function delete_register(id){
        if(confirm("¿Esta seguro de eliminarlo ?") ==  true)
        {
          $.get("eliminar_requisito_noguardado/"+id, function(res){
              filter_upload();
          });
        }
     }

     function filter_upload()
     {
        if($("#empresa").val()=="")
        {
          location.reload();
        }
       $.get(`fixing_filter/`+$("#empresa").val(), function(res){
              $('#ajax-content').empty();
              $('#ajax-content').html(res);
              table = $('#example').DataTable({"bSort": true,
               "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
                   },
               fixedHeader: {
                    header: true        
                },"pageLength": 50});
              console.log(table.data().count());
            });
     }

</script>