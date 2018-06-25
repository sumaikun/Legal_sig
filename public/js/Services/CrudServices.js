app.factory('CrudServices',['$http','$q',function($http,$q){
	
	var CrudServices = {};
    var defered = $q.defer();
    var promise = defered.promise;

    CrudServices.get_from_table = function(query)
	{
		var formData = new FormData();		
		formData.append('Acc', 'get_from_table');
		formData.append('query', query);
		return $http({
			url: "/angular/CrudController",
			method: "POST",
			data: formData,
			headers: { 
			  'Content-Type': undefined
			}
	   });
	}

	CrudServices.persist = function(data)
	{
	
		
		return $http.put("/angular/CrudController",data);		
	}

	CrudServices.delete = function(data)
	{
		return $http({
			url: "/angular/CrudController",
			method: "DELETE",
			data: data,
			headers: { 
			  'Content-Type': 'json'
			}
	   });
				
	}

	CrudServices.create = function(data)
	{
		return $http.post("/angular/CrudController",data);
				
	}

	CrudServices.getAll = function(data)
	{
		var formData = new FormData();		
		formData.append('Acc', 'getAll');
		formData.append('table', data.table);
		return $http({
			url: "/angular/CrudController",
			method: "POST",
			data: formData,
			headers: { 
			  'Content-Type': undefined
			}
	   });	   

	}

	CrudServices.getMETA_COLUMNS = function(data)
	{
		var formData = new FormData();		
		formData.append('Acc', 'META_COLUMNS');
		formData.append('table', data.table);
		return $http({
			url: "/angular/CrudController",
			method: "POST",
			data: formData,
			headers: { 
			  'Content-Type': undefined
			}
	   });	   

	}

	CrudServices.foreign_data = function(column)
	{
		var formData = new FormData();		
		formData.append('Acc', 'foreign_data');
		formData.append('column', column);
		return $http({
			url: "/angular/CrudController",
			method: "POST",
			data: formData,
			headers: { 
			  'Content-Type': undefined
			}
	   });	   

	}

	
	return CrudServices;	
	
}]);