app.factory('BrainServices',['$http','$q',function($http,$q){
	
	var BrainServices = {};
    var defered = $q.defer();
    var promise = defered.promise;


	BrainServices.test = function(week){
		//alert("got it");
		return $http.post(global_url+"angular/test");		

	}

	BrainServices.verify_first_asistant_view = function(){
		//alert("got it");
		return $http.get(global_url+"/angular/first_asistant_view");		

	}

	BrainServices.first_asistant_view_watched = function(data){
		//alert("got it");
		return $http.post(global_url+"/angular/first_asistant_view_watched",data);		

	}

	BrainServices.automatic_repair = function(data){
		return $http.post(global_url+"/angular/automatic_repair");	
	}


	BrainServices.get_duplicate_records = function(){
		//alert("got it");
		return $http.post(global_url+"/angular/get_duplicate_records");		

	}

	BrainServices.asistant_repair_duplicate = function(enterprise,art){
		//alert("got it");
		return $http.get(global_url+"/angular/asistant_repair_duplicate?enterprise="+enterprise+"&art="+art);		

	}

	BrainServices.Repair_requirements = function(data)
	{
		return $http.post(global_url+"/angular/repair_reqs",data);		
	}
	
	
	return BrainServices;	
	
}]);