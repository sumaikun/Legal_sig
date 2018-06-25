
        <table border="1">
	<thead>
		<tr>
			<th bgcolor="#FF8000">factorderiesgoaspecto</th>
			<th bgcolor="#FF8000">Grupo/Tema</th>
			<th bgcolor="#FF8000">CategoriadeRiesgo</th>
			<th bgcolor="#FF8000">TipodeNorma</th>
			<th bgcolor="#FF8000">Numero</th>
			<th bgcolor="#FF8000">Añodeemision</th>
			<th bgcolor="#FF8000">Autoridadquelaemite</th>
			<th bgcolor="#FF8000">articuloqueaplica</th>
			<th bgcolor="#FF8000">literal</th>
			<th bgcolor="#FF8000">NormasRelacionadas</th>		
			<th bgcolor="#FF8000">Obligatoria</th>
			<th bgcolor="#FF8000">Informativa</th>
			<th bgcolor="#FF8000">Derogada</th>
			<th bgcolor="#81BEF7">Requisitolegal</th>
			<th bgcolor="#81BEF7">EvidenciaEsperada</th>
			<th bgcolor="#81BEF7">Areadeaplicacion</th>
			<th bgcolor="#81BEF7">Cargocumplimiento</th>
			<th bgcolor="#088A08">fechaEvaluacion</th>
			<th bgcolor="#088A08">Calificacion</th>
			<th bgcolor="#088A08">EvidenciaCumplimiento</th>
			<th bgcolor="#088A08">fechaproxima</th>
		</tr>	
	</thead>
	<tbody>
	@foreach($requisitos as $requisito)
		<tr>
			<td style="height:35px;"> {{$requisito->Factor}} </td>
			<td style="height:35px;"> {{$requisito->Tipo}} </td>
			<td style="height:35px;"> {{$requisito->Categoria}} </td>
			<td style="height:35px;"> {{$requisito->Tpnorma}} </td>
			<td style="height:35px;"> {{$requisito->Numero}} </td>
			<td style="height:35px;"> {{$requisito->Emision}} </td>
			<td style="height:35px;"> {{$requisito->Autoridad}} </td>
			<td style="text-align:center;"> {{$requisito->Articulo}} </td>
			<td style="height:35px;"> {{$requisito->Literal}} </td>
			<td style="height:35px;"> {{$requisito->Nrelacionadas}} </td>	
			<td style="height:35px;"> @if($requisito->cl_id == 2 and $requisito->es_id != 2) {{"X"}} @endif  </td>
			<td style="height:35px;"> @if($requisito->cl_id == 1 and $requisito->es_id != 2) {{"X"}} @endif</td>
			<td>@if($requisito->es_id == 2) {{"X"}} @endif</td>
			<td style="height:35px;"> {{$requisito->Reqlegal}}</td>
			<td style="height:35px;"> {{$requisito->Esperada}}</td>
			<td style="height:35px;"> {{$requisito->Area}}</td>
			<td style="height:35px;"> {{$requisito->Cargo}}</td>
			<td style="height:35px;"> {{$requisito->Fecha}}</td>
			<td style="height:35px;"> {{$requisito->Calif}}</td>
			<td style="height:35px;"> {{$requisito->Cumplimiento}} </td>
			<td style="height:35px;">{{$requisito->Prox}}</td>
		</tr>
	@endforeach	
	</tbody>
</table>