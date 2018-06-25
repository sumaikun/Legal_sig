$(document).ready(function() {
$("#sector").change(event => {
	//console.log("Estoy llegando");
      var load = "<div class='loader'><span></span><span></span> <span></span></div>";
     $(".load").html(load)	
     if(event.target.value=="")
     {
     	$("#industria").empty();
     	$("#industria").append('<option> Selecciona <option>');
		$(".load").empty();
     }
     else
     { 
		$.get(`industria/${event.target.value}`, function(res, sta){
			$("#industria").empty();
			$(".load").empty();
			res.forEach(element => {
				$("#industria").append(`<option value=${element.idindustria}> ${element.industria} </option>`);
			});
		});
	}
});

});
