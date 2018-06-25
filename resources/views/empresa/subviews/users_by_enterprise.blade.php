<?php
	//print_r(Session::get('current_action')->get_desc_action());
?>

<form method="post" action="{{Session::get('current_action')->get_url()}}">
	{{ csrf_field() }}
	<input type="hidden" name="enterprise" value={{$enterprise_id}} />
	<table class="table">
		<thead>
			<tr>
				<th>id</th>
				<th>nombre</th>
				<th>opciones</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>{{$user->idusuario}}</td>
				<td>{{$user->nombre}}</td>
				<td><input name="user{{$user->idusuario}}" type="checkbox" value="{{$user->idusuario}}"
				<?php if(in_array($user->idusuario, $users_array)) { ?> checked <?php } ?> > </td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<button> {{ Session::get('current_action')->get_title_action() }} </button>
</form>