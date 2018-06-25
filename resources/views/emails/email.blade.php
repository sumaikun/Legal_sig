<!DOCTYPE html>
<html land="es">
<head>
	<meta charset="UTF-8">
	<title>Documento</title>
</head>
	<td><strong>{{$array["rol"]}} {{$array["empresa"]}}: </strong>  </td>  
	<br>

	<p>Apreciado usuario {{$array["nombre"]}} Los siguientes requisitos de la {{$array["titulo"]}} tiene {{$array["tiempo"]}} dias para vencerse :</p>
		<ul>
		@foreach($requisitos as $requisito)
			<li type="square">{{$requisito->TipoNorma}} , {{$requisito->Numero}} , Art. {{$requisito->ArticuloAplica}}</li>
		@endforeach
		</ul>
	<img src="../../logos/{{$array["logo"]}}"   class="img-responsive">
		<!--<img src=  <?php //echo $message->embed("../../logos/{{$array["logo"]}}") ?>  class="img-responsive">-->	
	
</html>

