<div class="modal fade" id="modalreplique" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>Replicar requisito
            </h4>
         </div>
         <div class="modal-body">              
            <div class="row">  
              <div class="col-lg-12">
                <form action="replique_req" id="replique_req" method="post">
                  <div class="form-group">
                    <label class="form-control">Empresa</label>
                    {!!Form::select('empresa',$empresas,null,['id'=>'sempresa','class'=>'form-control','placeholder'=>'Selecciona','required'=>'required'])!!}
                  </div>
                  <!--<div class="form-group">
                    <label class="form-control">Requisito Legal</label>
                    <textarea class="form-control" name="requisito_legal" required></textarea>
                  </div>
                  <div class="form-group">
                    <label class="form-control">Evidencia esperada</label>
                    <textarea class="form-control" name="evidencia_esperada" required></textarea>
                  </div> -->                 
                  <div class="form-group">
                    <label class="form-control">Clase</label>
                    <select name="clase" class="form-control" required>
                      <option value="">Selecciona</option>
                      @foreach($clases as $key=>$value)
                       <option value="{{$key}}">{{$value}}</option>
                      @endforeach
                    </select>
                  </div>
                  <input id="replicating_id" name="id" type="hidden">
                  <input name="_token" type="hidden" value="{{ csrf_token() }}">
                  <button class="form-control btn btn-success" type="submit">Guardar</button>
                </form>  
              </div>
            </div>      
         </div>
         <div class="modal-footer">
            <button type="button" id="literal_cancel_new"  class="btn btn-default" data-dismiss="modal">Cerrar</button>
            
         </div>
      </div>
   </div>
</div>

<script>
    $("#replique_req").submit(function(){

      var formData = new FormData($(this)[0]);

      $.ajax({
          url: 'replique_req',
          type: 'POST',
          data: formData,
          async: false,
          success: function (data) {
              alert(data);
              //$("#Comentariomodal").modal('hide');
          },
          cache: false,
          contentType: false,
          processData: false
      });

      return false;
  });
</script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>Cumplimiento
            </h4>
         </div>
         <div class="modal-body">
         <style>
          .fix_headerborder{
            border-bottom: 2px solid black !important;
          }
         </style>              
            <div class="row">  
              <div class="col-lg-12">
                <table  style="font-size: 75%;" class="table">
          <thead>
           <tr>
                  <th class="fix_headerborder">Normas relacionadas</th>
                  <th class="fix_headerborder">Requisito Legal</th>             
                  <th class="fix_headerborder">Clase</th>
                  <th class="fix_headerborder">Evidencia<br>esperada </th>
                  <th class="fix_headerborder">Responsable </th>
                  <th class="fix_headerborder">Area </th>
                  <th class="fix_headerborder"></th>
              </tr>
            </thead>
            <tbody>
              <td id="relacionada" contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"></td>
               <td id="reqlegal" contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"></td>
               <td id="clase"></td>
               <td id="evidencia" contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"></td>
               <td id="responsable" contenteditable="true" ></td>
               <td id="area" contenteditable="true"></td>
               <td></td>
            </tbody>
        </table>        
              </div>
            </div>      
         </div>
         <input type="hidden" id="cump_id">
         <div class="modal-footer">
             @if(Auth::user()->rol_id!=3)
             <button type="button" onclick="update_cumplimiento()"  class="btn btn-default" data-dismiss="modal">Guardar cambios</button>
             @endif
            <button type="button"  class="btn btn-default" data-dismiss="modal">Cerrar</button>     
         </div>
      </div>
   </div>
</div>

<script>
  function update_cumplimiento()
  {
    relacionada = $("#relacionada").text();
    reqlegal = $("#reqlegal").text();
    evidencia = $("#evidencia").text();
    responsable = $("#responsable").text();
    clase = $("#clase").text();
    //alert(clase);
    id = $("#cump_id").val();
    area = $("#area").text();
    
    $.post("matriz_update_cumplimiento", { relacionada:relacionada, reqlegal:reqlegal, evidencia:evidencia, responsable:responsable, area:area, id:id, _token:'{{ csrf_token() }}'} ,function(data){      
        if(data == "Actualizado")
        {
           document.getElementById('cump_btn'+id).setAttribute("onclick","addcumplimiento('"+relacionada+"',"+"'"+reqlegal+"',"+"'"+clase+"',"+"'"+evidencia+"',"+"'"+responsable+"',"+"'"+area+"',"+"'"+id+"')");
           document.getElementById('rel_cump'+id).setAttribute('onclick','show_relacionada("'+relacionada+'")');
           //$("#rel_cump"+id).attr("onclick",show_relacionada+"('"+relacionada+"')"); 
          alert("actualizado");
        }
      
    });  
  }
</script>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>Evaluación
            </h4>
         </div>
         <div class="modal-body">
         <style>
          .fix_headerborder{
            border-bottom: 2px solid black !important;
          }
         </style>              
            <div class="row">  
              <div class="col-lg-12">
                <table  style="font-size: 75%;" class="table">
                    <thead>
                     <tr>
                            <th class="fix_headerborder">Fecha</th>             
                            <th class="fix_headerborder">Evidencia</th>
                            <th class="fix_headerborder">Calificacion </th>
                            <th class="fix_headerborder">Proxima evaluacion </th>                 
                            <th class="fix_headerborder"></th>
                        </tr>
                      </thead>
                      <tbody>
                         <td id="fecha"></td>
                         <td id="cumpevidencia" contenteditable="false" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"></td>
                         <td id="calif"></td>
                         <td id="proxfecha" contenteditable="false" ></td>
                         <td style="text-align:center;"> <button style="margin-right: 5px;" onclick="all_evaluations()" title="Evaluaciones anteriores" class="btn btn-xs btn-warning"><i class="fa fa-history" aria-hidden="true"></i></button><button data-target="#Comentariomodal" data-toggle="modal"  class="btn btn-xs btn-success" title="Nuevo comentario"><i class="fa fa-comment" aria-hidden="true"></i></button> <button onclick="look_for_comments()" class="btn btn-xs btn-danger" title="Ver comentarios"><i class="fa fa-list" aria-hidden="true"></i></button> </td>
                         
                      </tbody>
                  </table>
                  <div id="eval_table_ajax"></div>        
              </div>
            </div>      
         </div>
         <div class="modal-footer">
            <button type="button"  id="close_category" class="btn btn-default" data-dismiss="modal">Cerrar</button>    
         </div>
      </div>
   </div>
</div>



<script>
  function look_for_comments()
  {
    id = $("#comment_req").val();
    $.get(`comments_in_req/`+id, function(res){              
        $("#comment-ajax-content").empty();
        $("#comment-ajax-content").append(res);
        $("#Comentariolist").modal('show');
    });
  }
  function all_evaluations()
  {
    $("#eval_table_ajax").empty();
     id = $("#comment_req").val();
    $.get(`all_evals/`+id, function(res){ $("#eval_table_ajax").append(res) });
  }
</script>

<div class="modal fade" id="Comentariolist" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>Lista de comentarios
            </h4>
         </div>
         <div class="modal-body">
         <style>
          .fix_headerborder{
            border-bottom: 2px solid black !important;
          }
         </style>              
            <div class="row">  
              <div class="col-lg-12">
                  <div id="comment-ajax-content"></div>
              </div>
            </div>      
         </div>
         <div class="modal-footer">            
            <button type="button"  id="close_category" class="btn btn-default" data-dismiss="modal">Cerrar</button>    
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="Comentariomodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="registercomment" id="register_form" enctype="multipart/form-data" method="post"> 
         <div class="modal-header">            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>Nuevo comentario
            </h4>
         </div>
         <div class="modal-body">
         <style>
          .fix_headerborder{
            border-bottom: 2px solid black !important;
          }
         </style>              
            <div class="row">  
              <div class="col-lg-12">
                  {{csrf_field()}}
                  <input type="hidden" name="requisito" id="comment_req"  class="idreq">                
                  <div class = "form-group">
                    <label>Titulo</label>
                    <input type="text" name="titulo" class="form-control">
                  </div>
                  <div class = "form-group">
                    <label>Comentario</label>
                    <textarea name="comentario" style="height: 100px;" class="form-control"></textarea>  
                  </div>
                  <div class = "form-group">
                    <label>Anexar archivo (no obligatorio)</label>
                    <input type="file" name="archivo">  
                  </div>
              </div>
            </div>      
         </div>
         <div class="modal-footer">
            <button type="submit"   class="btn btn-warning" >Guardar</button>
            <button type="button"  id="close_category" class="btn btn-default" data-dismiss="modal">Cerrar</button>    
         </div>
        </form> 
      </div>
   </div>
</div>

<script>
  $("#register_form").submit(function(){

    var formData = new FormData($(this)[0]);

    $.ajax({
        url: 'registercomment',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
            alert(data);
            $("#Comentariomodal").modal('hide');
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
});
</script>

<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content panel-success">
         <div class="modal-header panel-heading">            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i> <span id="reqproccess_title"></span>
            </h4>
         </div>
         <div class="modal-body">
            <form action="" id="form1"  method="post" enctype="multipart/form-data">

              {{csrf_field()}}
              <input type="hidden" name="infoempresa" val="">
              <div class="form-group">
                <label class="form-control">Tipo Matriz</label>
                <select class="form-control" name="tpmatriz" id="form1_tpmatriz" onclick="addfactores(this)" required>
                  <option value="">Selecciona</option>
                    @foreach($tiposmatriz as $key=>$value)
                    <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label class="form-control">Factor riesgo</label>
                <select name="factor" id="form1_factores" onclick="addcategorias(this)" class="form-control" required>
                  <option value="">Selecciona</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-control">Categoría riesgo</label>
                <select name="categoria" id="form1_categorias" class="form-control" required>
                  <option value="">Selecciona</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-control">Tipo norma</label>
                <select id="form1_tpnorma" class="form-control" name="tp_norma" onclick="addnormas(this)" required>
                  <option value="">Selecciona</option>                  
                    @foreach($tiposnorma as $tiponorma)
                    <option value="{{$tiponorma->id}}">{{$tiponorma->nombre}}</option>
                    @endforeach
                    <option value='new'>+ NUEVO TIPONORMA</button></option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-control">Norma</label>
                <select id="form1_norma" name="norma" onclick="addnorma_data(this)" class="form-control" required>
                  <option value="">Selecciona</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-control">Autoridad emisora</label>
                <select id="fm_autoridad"    class="form-control">
                  <option value="">Selecciona</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-control">Año de emision</label>
                <select id="fm_year"    class="form-control" >
                  <option value="">Selecciona</option>
                </select>
              </div>                       
              <div class="form-group">
                <label class="form-control">Articulo</label>
                <select id="form1_articulos" name="articulo" onclick="addliterales(this);" class="form-control" required>
                  <option value="">Selecciona</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-control">Literal</label>
                <select id="form1_literales" name="literal" class="form-control">
                  <option value="">Ninguno</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-control">Requisito legal</label>
                <textarea class="form-control" name="reqlegal" required></textarea>
              </div>
              <div class="form-group">
                <label class="form-control">Clase</label>
                <select name="clase" class="form-control" required>
                  <option value="">Selecciona</option>
                  @foreach($clases as $key=>$value)
                   <option value="{{$key}}">{{$value}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label class="form-control">Evidencia</label>
                <textarea class="form-control" name="esperada" required></textarea>
              </div>
              <div class="form-group">
                <label class="form-control">Responsable</label>
                <input type="text" name="responsable" class="form-control"></input>
              </div> 
              <div class="form-group">
                <label class="form-control">Area</label>
                <input type="text" name="area" class="form-control"></input>
              </div> 
              <button type="submit" class="btn btn-success">Guardar</button>
              <button type="reset" class="btn btn-danger">Limpiar</button> 
            </form>   
         </div>
         <div class="modal-footer">
            <button type="button"  class="btn btn-default" data-dismiss="modal">Cerrar</button>            
         </div>
      </div>
   </div>
</div>


<script>
    $("#form1").submit(function(){

      var formData = new FormData($(this)[0]);

      $.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          data: formData,
          async: false,
          success: function (data) {
              alert(data);
              $("#myModal3").modal('hide');
              //$("#form1").reset();
          },
          cache: false,
          contentType: false,
          processData: false
      });

      return false;
  });
</script>


<div class="modal fade" id="modealparameter1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>FACTOR RIESGO
            </h4>
         </div>
         <div class="modal-body">              
            <div class="row">  
              <div class="col-lg-12">
                <div class="form-group">      
                  <label>INGRESE EL NOMBRE DEL NUEVO FACTOR RIESGO</label>
                  <input  class="form-control" name="new_factor"  type="text"  required/>            
                </div>
              </div>
            </div>      
         </div>
         <div class="modal-footer">
            <button type="button"  id="factor_cancel_new" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" id="save_factor"   class="btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="modealparameter2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>CATEGORIA RIESGO
            </h4>
         </div>
         <div class="modal-body">              
            <div class="row">  
              <div class="col-lg-12">
                <div class="form-group">      
                  <label>INGRESE EL NOMBRE DE LA NUEVA CATEGORIA DE RIESGO</label>
                  <input  class="form-control" name="new_categoria"  type="text"  required/>            
                </div>
              </div>
            </div>      
         </div>
         <div class="modal-footer">
            <button type="button"  id="categoria_cancel_new" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" id="save_categoria"   class="btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="modealparameter3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>TIPO NORMA
            </h4>
         </div>
         <div class="modal-body">              
            <div class="row">  
              <div class="col-lg-12">
                <div class="form-group">      
                  <label>INGRESE EL NOMBRE DEL NUEVO TIPO DE NORMA</label>
                  <input  class="form-control" name="new_tpnorma"  type="text"  required/>            
                </div>
              </div>
            </div>      
         </div>
         <div class="modal-footer">
            <button type="button"  id="tpnorma_cancel_new"  class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" id="save_tpnorma"   class="btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="modealparameter4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>NORMA
            </h4>
         </div>
         <div class="modal-body">              
            <div class="row">  
              <div class="col-lg-12">
                <div class="form-group">      
                  <label>INGRESE EL NUMERO DE LA NORMA</label>
                  <input  class="form-control" name="new_norma"  type="text"  required/>            
                </div>
                <div class="form-group">
                <label class="form-control">Autoridad emisora</label>
                <select class="form-control" name="autoridad" id="form1_autoridad">
                  <option value="">Selecciona</option>
                    @foreach($autoridades as $autoridad)
                    <option value="{{$autoridad->id}}">{{$autoridad->nombre}}</option>
                    @endforeach
                    <option value='new'>+ NUEVA AUTORIDAD</button></option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-control">Año emision</label>
                <select class="form-control" name="emision" id="form1_year">
                  <option value="">Selecciona</option>
                    @foreach($years as $year)
                    <option value="{{$year->id}}">{{$year->year}}</option>
                    @endforeach
                </select>
              </div>     
                <div id="art_message"></div>
              </div>
            </div>      
         </div>
         <div class="modal-footer">
            <button type="button" id="norma_cancel_new"  class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" id="save_norma"   class="btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="modealparameter5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>AUTORIDAD EMISORA
            </h4>
         </div>
         <div class="modal-body">              
            <div class="row">  
              <div class="col-lg-12">
                <div class="form-group">      
                  <label>INGRESE EL NOMBRE DE LA NUEVA AUTORIDAD EMISORA</label>
                  <input  class="form-control" name="new_autoridad"  type="text"  required/>            
                </div>
              </div>
            </div>      
         </div>
         <div class="modal-footer">
            <button type="button" id="autoridad_cancel_new"  class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" id="save_autoridad"   class="btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="modealparameter6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>ARTICULO
            </h4>
         </div>
         <div class="modal-body">              
            <div class="row">  
              <div class="col-lg-12">
                <div class="form-group">      
                  <label>INGRESE EL NUMERO DEL ARTICULO</label>
                  <input  class="form-control" name="new_articulo"  type="text"  required/>            
                </div>                
              </div>
            </div>      
         </div>
         <div class="modal-footer">
            <button type="button"  id="articulo_cancel_new" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" id="save_articulo"   class="btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="modealparameter7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>LITERAL
            </h4>
         </div>
         <div class="modal-body">              
            <div class="row">  
              <div class="col-lg-12">
                <div class="form-group">      
                  <label>INGRESE EL NUMERO DEL LITERAL, PARAGRAFO, ETC..</label>
                  <input  class="form-control" name="new_literal"  type="text"  required/>            
                </div>
              </div>
            </div>      
         </div>
         <div class="modal-footer">
            <button type="button" id="literal_cancel_new"  class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" id="save_literal"   class="btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
         </div>
      </div>
   </div>
</div>

<script>

  $(document).on('hidden.bs.modal', function (event) {
    if ($('.modal:visible').length) {
      $('body').addClass('modal-open');
    }
  });

    $('select[name=factor]').change(function(){
      if ($(this).val() == 'new')
      {
        $('#modealparameter1').modal('show');               
      }
    });

    $('select[name=categoria]').change(function(){
      if ($(this).val() == 'new')
      {
        $('#modealparameter2').modal('show');               
      }
    });

    $('select[name=tp_norma]').change(function(){
      if ($(this).val() == 'new')
      {
        $('#modealparameter3').modal('show');            
      }
    });

    $('select[name=norma]').change(function(){
      if ($(this).val() == 'new')
      {
        $('#modealparameter4').modal('show');               
      }
    });

    $('select[name=autoridad]').change(function(){
      if ($(this).val() == 'new')
      {
        $('#modealparameter5').modal('show');               
      }
    });

    $('select[name=articulo]').change(function(){
      if ($(this).val() == 'new')
      {
        $('#modealparameter6').modal('show');               
      }
    });

    $('select[name=literal]').change(function(){
      if ($(this).val() == 'new')
      {
        $('#modealparameter7').modal('show');               
      }
    });

    $('#save_factor').click(function(){
    $.get('insertar_factor/'+$('input[name=new_factor]').val()+"/"+$("#form1_tpmatriz").val(), function(res){     
        var newValue = $('option', $('select[name=new_factor]')).length;
        $('<option>')
            .text($('input[name=new_factor]').val())
            .attr('value', res)
            .insertBefore($('option[value=new]', $('select[name=factor]')));        
        $('#modealparameter1').modal('hide');
        $('select[name=factor]').val(res);
      });    
  });
 $('#save_categoria').click(function(){
    $.get('insertar_categoria/'+$('input[name=new_categoria]').val()+"/"+$("#form1_factores").val(), function(res){    
        var newValue = $('option', $('select[name=categoria]')).length;
        $('<option>')
            .text($('input[name=new_categoria]').val())
            .attr('value', res)
            .insertBefore($('option[value=new]', $('select[name=categoria]')));        
        $('#modealparameter2').modal('hide');
        $('select[name=categoria]').val(res);
      });
  });
 $('#save_tpnorma').click(function(){
    $.get('insertar_tpnorma/'+$('input[name=new_tpnorma]').val(), function(res){    
        var newValue = $('option', $('select[name=tp_norma]')).length;
        $('<option>')
            .text($('input[name=new_tpnorma]').val())
            .attr('value', res)
            .insertBefore($('option[value=new]', $('select[name=tp_norma]')));        
        $('#modealparameter3').modal('hide');
        $('select[name=tp_norma]').val(res);
      });
  });
 $('#save_autoridad').click(function(){
    $.get('insertar_autoridad/'+$('input[name=new_autoridad]').val(), function(res){    
        var newValue = $('option', $('select[name=autoridad]')).length;
        $('<option>')
            .text($('input[name=new_autoridad]').val())
            .attr('value', res)
            .insertBefore($('option[value=new]', $('select[name=autoridad]')));        
        $('#modealparameter5').modal('hide');
        $('select[name=autoridad]').val(res);
      });
  });
 $('#save_norma').click(function(){
    if($('#form1_autoridad').val()=="" ||  $('#form1_year').val()=="")
    {
      $("#art_message").append('Debe agregar valores validos para autoridad emisora y año de emisión para poder guardar');
    }
    else{
      $.get('insertar_norma/'+$('input[name=new_norma]').val()+"/"+$('#form1_tpnorma').val()+"/"+$('#form1_year').val()+"/"+$('#form1_autoridad').val(), function(res){    
        var newValue = $('option', $('select[name=articulo]')).length;
        $('<option>')
            .text($('input[name=new_norma]').val())
            .attr('value', res)
            .insertBefore($('option[value=new]', $('select[name=norma]')));
        $(this).val(newValue);
        $('#modealparameter4').modal('hide');
        $('select[name=norma]').val(res);
      });
    }   
  });
 $('#save_articulo').click(function(){    
    $.get('insertar_articulo/'+$('input[name=new_articulo]').val()+"/"+$('#form1_norma').val(), function(res){    
        var newValue = $('option', $('select[name=articulo]')).length;
        $('<option>')
            .text($('input[name=new_articulo]').val())
            .attr('value', res)
            .insertBefore($('option[value=new]', $('select[name=articulo]')));
        $(this).val(newValue);
        $('#modealparameter6').modal('hide');
        $('select[name=articulo]').val(res);
      });
  });
 $('#save_literal').click(function(){
    $.get('insertar_literal/'+$('input[name=new_literal]').val()+"/"+$('#form1_articulos').val(), function(res){    
        var newValue = $('option', $('select[name=literal]')).length;
        $('<option>')
            .text($('input[name=new_literal]').val())
            .attr('value', res)
            .insertBefore($('option[value=new]', $('select[name=literal]')));
        $(this).val(newValue);
        $('#modealparameter7').modal('hide');
        $('select[name=literal]').val(res);
      });
  });
 /*if($('#form1_articulos').val()=="")
    {
      return $("#art_message").append("Debe seleccionar primero un numero de norma para realizar este procedimiento");
    }*/
  $("#tpnorma_cancel_new").click(function(){
    $('select[name=tp_norma]').val("");
  });
  $("#factor_cancel_new").click(function(){
    $('select[name=factor]').val("");
  });
  $("#categoria_cancel_new").click(function(){
    $('select[name=categoria]').val("");
  });
  $("#norma_cancel_new").click(function(){
    $('select[name=norma]').val("");
  });
  $("#autoridad_cancel_new").click(function(){
    $('select[name=autoridad]').val("");
  });
  $("#articulo_cancel_new").click(function(){
    $('select[name=articulo]').val("");
  });
  $("#literal_cancel_new").click(function(){
    $('select[name=literal]').val("");
  });  

  $('#form1').on('reset', function(){
      $("textarea[name='reqlegal']").empty();
      $("textarea[name='esperada']").empty();
      //document.getElementById('fm_year').selectedIndex = -1;
      //document.getElementById('fm_autoridad').selectedIndex = -1;
      $("#fm_year").children().removeAttr("selected");
      $("#fm_autoridad").children().removeAttr("selected");
      $("#fm_year").val("");
      $("#fm_autoridad").val("");
  });

</script>