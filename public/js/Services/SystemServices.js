app.factory('SystemServices',['$http','$q',function($http,$q){
	
	var SystemServices = {};
    var defered = $q.defer();
    var promise = defered.promise;

    SystemServices.replace_delete = function(data)
    {
    	return $http.post(global_url+"/angular/delete_replace",data);
    }

    SystemServices.derogar = function(data)
    {
        return $http.post(global_url+"/angular/derogar",data);
    }

    SystemServices.desderogar = function(data)
    {
        return $http.post(global_url+"/angular/desderogar",data);
    }

    SystemServices.get_sessions = function()
    {
        return $http.post(global_url+"/angular/get_sessions");   
    }

    SystemServices.derogar_info = function(data)
    {
        return $http.post(global_url+"/angular/derogar_info",data);   
    }

    SystemServices.save_property_to_db = function(data)
    {
        return $http.post(global_url+"/angular/save_property_to_db",data);   
    }    

	
	return SystemServices;	
	
}]);