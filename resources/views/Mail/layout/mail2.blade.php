
Los siguientes registros de su matriz de requisitos legales están vencidos o próximos a vencerse .<br>
<table style=" border: 1px solid black;">
	<thead >
		<tr>
			<th style=" border: 1px solid black;">id</th>
			<th style=" border: 1px solid black;">tipo norma</th>
			<th style=" border: 1px solid black;">norma</th>
			<th style=" border: 1px solid black;">articulo</th>
		</tr>
	</thead>
	<tbody>
		@foreach($registros as $registro)
		<tr>
			<td style=" border: 1px solid black;">{{$registro->id}}</td>
			<td style=" border: 1px solid black;">{{$registro->tpnorma}}</td>
			<td style=" border: 1px solid black;">{{$registro->norma}}</td>
			<td style=" border: 1px solid black;">{{$registro->articulo}}</td>
		</tr>
		@endforeach
	</tbody>
</table>

Para revisarlos ingrese al aplicativo de requisitos legales del Grupo SIG: <a href="www.reqlegalsig.com">www.reqlegalsig.com</a>

<p><img src="http://grupo-sig.com/images/werwer.png" title="Image: http://grupo-sig.com/images/werwer.png"><br></p>
