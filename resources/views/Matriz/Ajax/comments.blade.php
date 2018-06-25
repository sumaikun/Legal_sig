<table class="table">
	<thead>
		<th>Titulo</th>
		<th>Comentario</th>
		<th>Archivo</th>
	</thead>
	<tbody>
		@foreach($comentarios as $comentario)
		<tr>
			<td onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$comentario->titulo}} </td>
			<td onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$comentario->comentario}} </td>
			<td> @if($comentario->archivo != null) <a href="archivo_comentario/{{$comentario->id}}"><button class="btn btn-xs btn-success ">Archivo</button></a> @endif </td>
		</tr>
		@endforeach
	</tbody>
</table>