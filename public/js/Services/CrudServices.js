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
			url: global_url+"/angular/CrudController",
			method: "POST",
			data: formData,
			headers: { 
			  'Content-Type': undefined
			}
	   });
	}

	CrudServices.persist = function(data)
	{
	
		
		return $http.put(global_url+"/angular/CrudController",data);		
	}

	CrudServices.delete = function(data)
	{
		return $http({
			url: global_url+"/angular/CrudController",
			method: "DELETE",
			data: data,
			headers: { 
			  'Content-Type': 'json'
			}
	   });
				
	}

	CrudServices.create = function(data)
	{
		return $http.post(global_url+"/angular/CrudController",data);
				
	}

	CrudServices.getAll = function(data)
	{
		var formData = new FormData();		
		formData.append('Acc', 'getAll');
		formData.append('table', data.table);
		return $http({
			url: global_url+"/angular/CrudController",
			method: "POST",
			data: formData,
			headers: { 
			  'Content-Type': undefined
			}
	   });	   

	}

	SystemService.getBy = function(get)
	{
		data = {};
		data.properties = get.get;
		data.Acc = 'getBy';
		data.table = get.table;
		return $http.post(global_url+"/angular/CrudController",data)
	}


	CrudServices.getBy = function(data)
	{
		var formData = new FormData();		
		formData.append('Acc', 'getBy');
		formData.append('table', data.table);
		formData.append('index', data.index);
		formData.append('value', data.value);
		return $http({
			url: global_url+"/angular/CrudController",
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
			url: global_url+"/angular/CrudController",
			method: "POST",
			data: formData,
			headers: { 
			  'Content-Type': undefined
			}
	   });	   

	}

	CrudServices.foreign_data = function(column,table)
	{
		var formData = new FormData();		
		formData.append('Acc', 'foreign_data');
		formData.append('column', column);
		formData.append('table', table);
		return $http({
			url: global_url+"/angular/CrudController",
			method: "POST",
			data: formData,
			headers: { 
			  'Content-Type': undefined
			}
	   });	   

	}

	
	return CrudServices;	
	
}]);