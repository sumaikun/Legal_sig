@extends('layouts.admin')


 @section('content')

	<div class="row table-responsive" style="max-height:500px !important;">
		<div class="col-md-6 col-lg-6 ">	
			<table class="table table-bordered table-hover" style="margin-top: 30px;">	
				<thead class="thead-dark">
					<th>Nombre</th>
				</thead> 
				<tbody>
				 @foreach($empresas as $empresa)
					<tr>
						<td onclick="look_for_users('{{$empresa->idempresa}}')">{{$empresa->nombre}}</td>
					</tr>
				 @endforeach
				 </tbody>	
			</table>
		</div>
		<div class="col-md-6 col-lg-6 ">
			<div class = "load col-lg-12" style= "max-height:0px; margin-top: 15px;" >
   			</div>
			<div id="ajax-content" style="margin-top: 30px;">
			</div>
		</div>
	</div>

 @stop
<script>

var ent_selected;

 function look_for_users(id)
 {
 	ent_selected = id;
 	 var load = "<div class='loader'><span></span><span></span> <span></span></div>";
          $(".load").append(load) ;	

 	$.post( "../users_by_enterprise",{enterprise_id:id,_token:'{{ csrf_token() }}' },function( data ) {
 	 	
	  $( "#ajax-content" ).html( data );
	  $(".load").empty();
	});
 }

</script>