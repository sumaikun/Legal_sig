@extends('layouts.admin')
    @section('content')
      


<script type="text/javascript">
	window.onload = function () {
		var chart = new CanvasJS.Chart("chartContainer", {
			title: {
				text: "Gráficas de analisis"
			},	
			data: [{
				type: "column",
				indexLabelLineThickness: 2,
				dataPoints: [
					  			 
				]
			}]
		});
		chart.render();
	}
</script>

{{Html::script('js/canvasjs.min.js')}}

<div class="row">
	<div class="col-lg-12" style="margin-top: 35px;">
		<div id="chartContainer" style="height: 300px; width: 100%;"></div>
	</div>
	<div class="col-lg-12" style="margin-top: 25px;">
		<div class="form-group col-lg-3">
            {!!Form::label('Empresa')!!}
            <select id="empresa" class="form-control">
            	<option>Selecciona</option>
            	@foreach($empresas as $key => $temp)
            		<option value="{{$key}}"> {{$temp}} </option>
            	@endforeach
            </select>            
		</div>
		<div class="form-group col-lg-3">
			<label>Tipo de gráfica</label>
			<select id="tipo" class="form-control">
				<option> Selecciona </option>
				<option value="1">General</option>
				<option value="2">Factores riesgo</option>
			</select>
		</div>
		<div class="form-group col-lg-3" style="margin-top: 18px;">
			<button onclick="test()" class="btn btn-primary">Generar</button>
		</div>
	</div>	
</div>

<script type="text/javascript">

	function test()
	{
		empresa = $("#empresa").val();
		tipo = $("#tipo").val();

		if(empresa == "Selecciona" || tipo == "Selecciona")
		{
			return alert("Debe seleccionar valores validos para este proceso");
		}

	 	$.get("gcharts/"+empresa+"/"+tipo, function(res){
	 		if(tipo==1)
	 		{
	 			var chart = new CanvasJS.Chart("chartContainer",
				{
					title:{
						text: "Graficas de analisis"
					},

					data: [
					{
						type: "column",
						dataPoints: [
							{ x: 10, y: res[0].y, label:"100 %" },
							{ x: 20, y: res[1].y, label:"0 %" },					
						]
					}
					]
				});

				chart.render();	
	 		}
	 		if(tipo==2)
	 		{
	 			var chart = new CanvasJS.Chart("chartContainer",
				{
					title:{
						text: "Graficas de analisis"
					},

					data: [
					{
						type: "column",
						dataPoints: res
					}
					]
				});

				chart.render();	
	 		}

            
          });
	}
</script>

@stop