
<table id="duplicate_registers" class="table table-responsive table-hover">
	<thead>
		<tr>
			<th>Empresa</th>
			<th>Tipo norma</th>
			<th>Norma</th>
			<th>Articulo</th>			
			<th>Cantidad</th>
		</tr>
	</thead>
	<tbody>
		@foreach($registros as $registro)
		<tr onclick="angular.element(this).scope().asistant_repair_duplicate('{{$registro->id_empresa}}','{{$registro->id_Articulos}}')">
			<td> {{$registro->empresa}}  </td>
			<td> {{$registro->tipo_norma}}	</td>		
			<td> {{$registro->norma}}</td>
			<td> {{$registro->articulo}}</td>
			<td> {{$registro->CNT}}</td>
		</tr>
		@endforeach
	</tbody>
</table>

