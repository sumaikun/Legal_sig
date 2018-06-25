app.factory('SystemServices',['$http','$q',function($http,$q){
	
	var SystemServices = {};
    var defered = $q.defer();
    var promise = defered.promise;

    SystemServices.replace_delete = function(data)
    {
    	return $http.post("/angular/delete_replace",data);
    }

    SystemServices.derogar = function(data)
    {
        return $http.post("/angular/derogar",data);
    }

    SystemServices.desderogar = function(data)
    {
        return $http.post("/angular/desderogar",data);
    }

    SystemServices.get_sessions = function()
    {
        return $http.post("/angular/get_sessions");   
    }

    SystemServices.derogar_info = function(data)
    {
        return $http.post("/angular/derogar_info",data);   
    }



	
	return SystemServices;	
	
}]);