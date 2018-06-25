<table  style="font-size: 75%;" class="table">
	<thead>
		<th  class="fix_headerborder" colspan="5">Evaluaciones anteriores</th>
	</thead>
	<tbody>		
	@foreach($evaluations as $eval)
		<tr>
			 <td> {{$eval->fecha}} </td>
		     <td  contenteditable="false" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"> {{$eval->cumplimiento}} </td>
		     <td > {{$eval->Calificacion}} </td>
		     <td  contenteditable="false"> {{$eval->fecha_prox}} </td>
		     <td style="text-align:center;"> </td>
		</tr>
	@endforeach
	</tbody>
</table>