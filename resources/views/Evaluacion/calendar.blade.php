<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
{{Html::style('js/calendar/fullcalendar.css')}}
<link href="{{url('js/calendar/fullcalendar.print.css')}}" rel='stylesheet' media='print' />
{{Html::script('js/calendar/moment.min.js')}}
{{Html::script('js/calendar/jquery.min.js')}}
{{Html::script('js/calendar/fullcalendar.min.js')}}
<script>

	$(document).ready(function() {
		var id = Math.floor('<?php echo $id ?>');    
       	var empresa = Math.floor('<?php echo $empresa ?>');   
		 	var prueba2= $.get(`gDates/`+id+`/`+empresa, function(res){
            var dato = res;

            if(res==''){
            	console.log('nulo');  
            	return $(".datoscumplimiento").append('<p>"El requisito no aplica para la empresa seleccionada"</p>'); 
            }
            //          
          });	

		  prueba2.done(  function(res){
		  console.log(res);	
		  console.log(JSON.stringify(res,null,2));
		  var array = $.map(res, function(value, index){
            	return [value];
            });
		  console.log(array.length);
		   var events = [];
            for (var i=0; i<array.length ;i++)
            {
            	events.push({title:'evaluación '+(i+1),start:array[i],id:i})
            }
              var titulo = "soy un titulo";
		      var fecha = array[0];
		  
		$('#calendar').fullCalendar({
			defaultDate: '{{Sig\Helpers\Externclass::today()}}' ,
			editable: true,
			eventLimit: true, // allow "more" link when too many events

			events: events,
			eventClick: function(calEvent, jsEvent, view) {

	        console.log('Event: ' + calEvent.title);
	        console.log('Event: ' + calEvent.id);

	        $(this).css('background-color', '#0072ff');
	      
	        var prueba= $.get(`gSpecified/`+id+`/`+calEvent.id+`/`+empresa, function(res){
            var dato = res;
           
            $('.datoscumplimiento').empty();
            $(".datoscumplimiento").html(dato); 

            });
   		   }
		});
	   });
		
	});

</script>
<style>

	body {
		margin: 40px 10px;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}
	div.fc-left >h2 {
		visibility: visible;
		color: black;
	}

</style>
</head>
<body>

	<div id='calendar'></div>

</body>
</html>