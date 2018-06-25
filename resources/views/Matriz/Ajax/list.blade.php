<style>
.circle:before {
  content: ' \25CF';
  font-size: 20px;
  color: red;
}


<?php if(isset($estado_requisitos)){  ?>

  <?php if($estado_requisitos == 1){  ?>

    .expired{
      display:none;
    }

  <?php } ?>

  <?php if($estado_requisitos == 2){ ?>

    .ondate{
      display:none;
    }

  <?php } ?>

<?php } ?>

</style>
<table id="example" style="font-size: 75%;" class="table">
			<thead>
			 <tr>
		          <th>Id </th>		          
		          <th>Grupo/Tema</th>
		          <th>Factor Riesgo </th>
		          <th>Categoria </th>  		    
		          <th> Tipo de<br> Norma </th> 
		          <th> Número </th> 
		          <th> Año <br>Emision </th>                        
		          <th> Autoridad <br>Emisora </th> 
		          <th style="max-width:40px;"> Artículos </th> 
		          <th> Estado<br>Articulo</th>
		          <th style="max-width:50px;"> Literal </th>	          		          
		          <th>btn</th>
		      </tr>
			</thead>
	        <tbody>
		     <!--
		        <td contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)">Con position:absolute el objeto tomara como referencia a un objeto de posición estatica para poder modificar su posición.
		Con position relative se comporta como un static pero que se le pueden agregar unos valores extra para modificarlo.
		Con el position fixed un elemento se queda fijo en la pantalla y puede desplazarse a través de otros objetos.
		</td>-->

		       @foreach($requisitos as $requisito)


		        <tr <?php if(Sig\Helpers\Externclass::time_dates((string)$requisito->Prox)<= 8) {  ?> class="expired" <?php }else { ?> class="ondate"  <?php } ?> >
		       		<td> {{$requisito->id}} <span style="width:5px;"></span> @if(Auth::user()->rol_id!=3 and $requisito->es_id!=2)<input type="checkbox" value="{{$requisito->id}}" class="req_checks" onclick="insert_requirement(this)"  name="requisito{{$requisito->id}}">@endif @if(Sig\Helpers\Externclass::time_dates((string)$requisito->Prox)<= 8 and $requisito->es_id!=2) <span title="Próximo a vencerse" class="circle"></span>@endif </td>
		       		<td> {{$requisito->Tipo}} </td>
		       		<td onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->Factor}} </td>
		       		<td  onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->Categoria}} </td>		     
		       		<td onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->Tpnorma}}</td>
		       		<td onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->Numero}} <a id="rel_cump{{$requisito->id}}" title="Normas relacionadas" onclick="show_relacionada('{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->relacionada)}}')"><i class="fa fa-book" aria-hidden="true"></i></a> </td>
		       		<td> {{$requisito->Emision}}</td>		       		
		       		<td onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->Autoridad}}</td>		       		
		       		<td style="max-width:50px;" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->Articulo}}</td>
		       		<td> {{$requisito->Estado}}</td>
		       		<td style="max-width:60px;" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->Literal}}</td>
		       		<td contenteditable="false" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> 
		       	
		       		<a href="#" data-toggle="modal" title="Cumplimiento"  id="cump_btn{{$requisito->id}}" onclick="addcumplimiento('{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->relacionada)}}','{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->Reqlegal)}}','{{(string)$requisito->Clase}}','{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->Esperada)}}','{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->Cargo)}}','{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->Area)}}','{{$requisito->id}}')" data-target="#myModal"><i class="fa fa-cog" aria-hidden="true"></i></a>
		       		<a href="#" data-toggle="modal" title="Ultima Evaluación" onclick="addevaluacion('{{$requisito->id}}')" data-target="#myModal2"><i class="fa fa-user" aria-hidden="true"></i></a>		       		
		       		  @if(Auth::user()->rol_id!=3)<a href="#" title="editar" onclick="requisito_edit({{$requisito->id}})"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>@endif  
		       		@if(Auth::user()->rol_id == 1 or Auth::user()->rol_id == 2)<a href="delete_requisito/{{$requisito->id}}" onclick="return confirm('¿Eliminar requisito?')" title="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>@endif
		       		@if(Auth::user()->rol_id!=3)<a href="#reply_req" onclick="replique_req({{$requisito->id}})" title="Replicar requisito"><i class="fa fa-forward" aria-hidden="true"></i></a>@endif
		       		<!--
              {{(string)$requisito->Fecha}}','{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->Cumplimiento)}}','{{$requisito->Calif}}','{{(string)$requisito->Prox}}','{{$requisito->id}}
              -->
              </td>
		       		
		      	</tr>
		      	
		       @endforeach
		      
	     
	   		</tbody>
	   		<tfoot>
			 <tr>
		        <th>Id </th>		          
		          <th>Grupo/Tema</th>
		          <th>Factor Riesgo </th>
		          <th>Categoria </th>        
		          <th>Normas<br>relacionadas</th>		      
		          <th> Número </th> 
		          <th> Año <br>Emision </th>                        
		          <th> Autoridad <br>Emisora </th> 
		          <th style="max-width:40px;"> Artículos </th> 
		          <th> Estado<br>Articulo</th>
		          <th style="max-width:50px;"> Literal </th>		          		    
		          <th>total {{count($requisitos)}} @if(strtoupper($ent_name)=="VALIDACIONES")<button onclick="pass_data()">Pasar datos</button> @endif</th>
		      </tr>
	   		</tfoot>
	    </table>

  <script>
  	function replique_req(id)
  	{
  		$("#replicating_id").val(id);
  		$("#modalreplique").modal('show');
  	}
  </script>	    

  <div class="modal fade" id="modalevaluation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="evaluate" id="evaluate" method="post">
         <div class="modal-header">            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>Evaluación
            </h4>
         </div>
         <div class="modal-body">              
            <div class="row">  
              <div class="col-lg-12">
                
                <label>Fecha de evaluación</label>

                <input type='date' name='fecha' id="fechaini"  value='{{ date("Y-m-d") }}' class='form-control'>
                
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

                <input type="hidden" name="reqs_to_eval" value="" id="reqs_to_eval">

                 <div class="form-group">
                        {!!Form::label('Evidencia de Cumplimiento')!!}
                        {!!Form::textarea('evidenciacump',null,['id'=>'evidenciacump','class'=>'form-control','placeholder'=>'Ingrese la evidencia de cumplimiento','style'=>'max-height: 100px !important;' ,'maxlength'=>'2500','required','minlength'=>'30'])!!}
                 </div>

                    <div class="form-group">
                      <span class="title">Calificación</span>
                     

                        @if($tipo_eval==1)

                        {!!Form::label('0')!!}
                        {!!Form::radio('calificacion', '0',['required'])!!}
                        {!!Form::label('100')!!}
                        {!!Form::radio('calificacion', '100')!!}

                        @else
                        {!!Form::label('0')!!}
                        {!!Form::radio('calificacion', '0',['required'])!!}
                        {!!Form::label('50')!!}
                        {!!Form::radio('calificacion', '50')!!}
                        {!!Form::label('100')!!}
                        {!!Form::radio('calificacion', '100')!!}

                        @endif

                      
                    </div>  
                    <?php $date = new DateTime('+1 day'); ?>
                  <div class="form-group">
                        {!!Form::label('Fecha Proxima evaluación')!!}
                        {!!Form::date('fechaprox',null,['id'=>'fechaprox','class'=>'form-control','required'])!!}
                  </div>                 
              </div>
            </div>      
         </div>
         <div class="modal-footer">
            <button type="button" id="literal_cancel_new"  class="btn btn-default" data-dismiss="modal">Cerrar</button>
            {!!Form::submit('Registrar',['class'=>'btn btn-primary ','id'=>'submit'])!!}
         </div>
         </form> 
      </div>
   </div>
</div>

<script>
    $("#evaluate").submit(function(){
        

        //return false;

        var datetimeStart = $("#fechaini").val(); 
        var datetimeEnd = $("#fechaprox").val();

        if(Date.parse(datetimeStart) >= Date.parse(datetimeEnd)){
           alert("El valor de la fecha de proxima evaluación no puede ser menor o igual al de fecha de evaluación");
           return false;
        }else{

           //alert("Fechas mandadas correctamente");
        }    

      var formData = new FormData($(this)[0]);

      $.ajax({
          url: 'evaluate',
          type: 'POST',
          data: formData,
          async: false,
          success: function (data) {
              alert(data);
              $("#modalevaluation").modal('hide');
              $('#evaluate')[0].reset();              
              //$("input:checkbox").prop('checked', $(this).prop("checked"));
              $('#evaluate')[0].reset();   
              $("#reqs_to_eval").val("");      
              $('input[type=checkbox]').each(function() 
              { 
                      this.checked = false; 
              }); 
              checkboxesChecked = [];
              $("#modalevaluation").modal('hide');
          },
          cache: false,
          contentType: false,
          processData: false
      });

      return false;
  });
</script>



<script>
	$(document).ready(function(){
      /*$('.req_checks').click(function(){
          if(($('.req_checks:checked').length)>1)
          {
          	$('.btn_one_req').prop( "disabled", true );
          }
          else{
          	$('.btn_one_req').prop( "disabled", false );
          }

      });*/
    });

   function pass_data()
   {
   	$("#modalpassdata").modal('show');
   }

   function show_relacionada(relacionada)
   {
   		alert("Normas relacionadas:"+relacionada);
   }
</script>

