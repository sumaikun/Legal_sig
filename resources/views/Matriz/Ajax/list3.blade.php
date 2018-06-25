<style>
.circle:before {
  content: ' \25CF';
  font-size: 20px;
  color: red;
}
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
		          <th> Estado</th>
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
		        <tr>
		       		<td> {{$requisito->id}} <span style="width:5px;"></span> @if(Auth::user()->rol_id!=3 and $requisito->es_id!=2)<input type="radio" value="{{$requisito->id}}"  name="primordial">@endif @if(Sig\Helpers\Externclass::time_dates((string)$requisito->Prox)<= 8) <span title="Próximo a vencerse" class="circle"></span>@endif </td>
		       		<td> {{$requisito->Tipo}} </td>
		       		<td onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->Factor}} </td>
		       		<td  onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->Categoria}} </td>    	
		       		<td onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->Tpnorma}}</td>
		       		<td onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->Numero}}  </td>
		       		<td> {{$requisito->Emision}}</td>		       		
		       		<td onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->Autoridad}}</td>		       		
		       		<td style="max-width:50px;" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->Articulo}}</td>
		       		<td> {{$requisito->Estado}}</td>
		       		<td style="max-width:60px;" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$requisito->Literal}}</td>
		       		<td contenteditable="false" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> 
		       	
		       		<a href="#" data-toggle="modal" title="Cumplimiento"  id="cump_btn{{$requisito->id}}" onclick="addcumplimiento('{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->relacionada)}}','{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->Reqlegal)}}','{{(string)$requisito->Clase}}','{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->Esperada)}}','{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->Cargo)}}','{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->Area)}}','{{$requisito->id}}')" data-target="#myModal"><i class="fa fa-cog" aria-hidden="true"></i></a>
		       		<a href="#" data-toggle="modal" title="Ultima Evaluación" onclick="addevaluacion('{{(string)$requisito->Fecha}}','{{Sig\Helpers\Validation::escapeJavaScriptText((string)$requisito->Cumplimiento)}}','{{$requisito->Calif}}','{{(string)$requisito->Prox}}','{{$requisito->id}}')" data-target="#myModal2"><i class="fa fa-user" aria-hidden="true"></i></a>		       		
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
		          <th> Estado</th>
		          <th style="max-width:50px;"> Literal </th>		          		    
		          <th>total {{count($requisitos)}} @if(strtoupper($ent_name)=="VALIDACIONES")<button onclick="pass_data()">Pasar datos</button> @endif</th>
		      </tr>
	   		</tfoot>
	    </table>


<script>
	function addcumplimiento(nrelacionada,reqlegal,clase,evidencia,responsable,area,id){
      /*console.log('existo'+nrelacionada);
      console.log('existo'+reqlegal);
      console.log('existo'+clase);
      console.log('existo'+evidencia);
      console.log('existo'+responsable);
      console.log('existo'+area);
      console.log('existo'+id);*/
      $("#relacionada").empty();
      $("#reqlegal").empty();
      $("#clase").empty();
      $("#evidencia").empty();
      $("#responsable").empty();
      $("#area").empty();
      $("#cump_id").val(id);
      $("#relacionada").append(nrelacionada);
      $("#reqlegal").append(reqlegal);
      $("#clase").append(clase);
      $("#evidencia").append(evidencia);
      $("#responsable").append(responsable);
      $("#area").append(area);

    }

    function addevaluacion(fecha,evidenciacump,calificacion,fechaprox,id){
      console.log('existo');
      $("#fecha").empty();
      $("#cumpevidencia").empty();
      $("#calif").empty();
      $("#proxfecha").empty();
      //console.log("prueba"+evidenciacump);      

      $("#fecha").append(fecha);
      $("#cumpevidencia").append(evidenciacump);
      $("#calif").append(calificacion);
      $("#proxfecha").append(fechaprox);

      $("#eval_table_ajax").empty();
      $(".idreq").val(id);
    }
</script>