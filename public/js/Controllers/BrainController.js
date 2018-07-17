app.controller('BrainController',['$scope','BrainServices','$compile','$window',function($scope,BrainServices,$compile,$window){

	$scope.title = "Prueba";
	$scope.action = "";
	$scope.years = {};
	$scope.modal = {};
	$scope.req = {};

	$scope.test = function(){
		var request = BrainServices.test();
		request.then(function(response){			
			//console.log(response);
			$scope.years = response.data;
			$("#myModaltest").modal('show');
		});
	}

	$scope.edit_year = function(id){
		alert("Voy a editar el id "+id);
	}

	$scope.verify_first_asistant_view = function(){
		var request = BrainServices.verify_first_asistant_view();
		request.then(function(response){	
			//console.log(response.data);
			$scope.modal = 	response.data;
			$scope.modal.view = global_url+"/"+response.data.view;				
			if(response.data.status == 'not done')
			{				
				console.log($scope.modal); 
				$("#myModaltest").modal('show');
			}			
		});
	}

	$scope.verify_first_asistant_view_watched = function(){
		var request = BrainServices.first_asistant_view_watched($scope.modal);
		request.then(function(response){	
			console.log(response);			
		});
	}

	$scope.automatic_repair = function(){
		var request = BrainServices.automatic_repair();
		request.then(function(response){	
			alert(response.data)		
		});
	}

	$scope.get_duplicate_records = function(){
		var request = BrainServices.get_duplicate_records();
		request.then(function(response){	
			//var $el = $(response.data).append('#ajax-operator-content');
			 //$compile($el)($scope);
			$('#ajax-operator-content').html(response.data);
			$('#duplicate_registers').DataTable({"bSort": false,"language": {"url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"}})	
			$("#myModalOperator").modal('show');	
		});
	}

	$scope.asistant_repair_duplicate = function(enterprise,art){
		//alert("clicked "+enterprise+"art "+art);
		var request = BrainServices.asistant_repair_duplicate(enterprise,art);
		request.then(function(response){	
			
			$('#ajax-operator-content2').html(response.data);
			//$('#duplicate_registers').DataTable({"bSort": false,"language": {"url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"}})	
			$("#myModalOperator2").modal('show');
			$scope.action = "Repair_requirements";	
		});
	}

	$scope.Repair_requirements = function()
	{
		if($('input[name=primordial]:checked').val() == null)
		{
			return alert("Debes seleccionar primero el requisito base que unificara los demas");
		}
		else
		{			
			$scope.req.id =  $('input[name=primordial]:checked').val();
			var request = BrainServices.Repair_requirements($scope.req);
			request.then(function(response){	
				$scope.get_duplicate_records();
				alert("requisito eliminado");
			});
		}
		
	}


	$scope.operator_action = function()
	{
		console.log("Accion "+$scope.action);
		//var fn = $scope.action;
		//$scope.Repair_requirements();
		var fn = "$scope."+$scope.action;
		//fn = $scope.$window[fn]();
		eval(fn)();
		console.log(fn);
		

	}

	$scope.relative_path = function(path)
	{
		var url = global_url+path;
		//console.log(url);
		return url;
	}

}]);