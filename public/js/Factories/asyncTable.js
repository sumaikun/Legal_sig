
	table.prototype.ng_table_adapter_filter = function(columnarray)
	{
		var object_columns = this.columns;		
		columnarray.forEach(function(column){

	
			

			var filter_object = {};
			filter_object["Field"] = column.column;	

			var element = $filter('filter')(object_columns,filter_object)[0];
			

			if(element == null)
			{
				element = get_element_by_index(object_columns,"Field",column.column);
			}			

			

				if(column.typefilter == "select")
				{
					if(element.key_data != null)
					{						
						var filter_obj = {};
	  					var filter_type = "select";
		  				filter_obj[element.Field] = filter_type; 	 	  
						element.filter= filter_obj;
						//console.log(element.key_data);							
		  				element.filterData = create_filter_object(element.key_data);	
					}
					
				}
						
		});
		
	}

	table.prototype.crudcontrol = function(buttons){
		var extra_column = {"Field":"Opciones","title":"Opciones","actions":buttons};
		this.columns.push(extra_column);
	}

	
	table.prototype.ng_table_extra_foreigns_columns = function(columnarray)
	{
		var new_columns = [];
		var object = this;
				

		columnarray.forEach(function(element){
				
				var current_row = get_reference_model_name(object,element.model);
				element.columns.forEach(function(subelement){
					var foreign_row = $filter('filter')($scope[element.model.capitalize()].columns,{Field:subelement})[0];
					
					new_column = {};
					new_column.Field = subelement;
					new_column.title = subelement+"("+element.model+")";					
					new_column.key_data = foreign_row.key_data;
					new_column.foreign_column = foreign_row.key_data;
					new_column.local_column = current_row.key_data; 
					object.columns.push(new_column);

					object.rows.forEach(function(row){
						row[subelement] = $scope.foreign_extra_value(row,new_column);
					});

				});
			});		
		
	}

	get_reference_model_name = function(object,model)
	{		
		var mul_cols = $filter('filter')(object.columns,{Key:"MUL"});
		var searched_column = {};
		mul_cols.forEach(function(element){			
			if(element.key_data.REFERENCED_TABLE_NAME.capitalize() == model)
			{
				searched_column = element;
			}
		});
		return searched_column; 
	}



	table.prototype.ng_table_adapter = function(columnsname)
	{
		 var ajax_resource = this.resource;
		 this.columns.forEach(function(element) {	 	  
		  //Add features for ng-table
		  //console.log(object);

		  element.show = true;

		  if(columnsname != "*")
		  {
		  	if(!columnsname.contains(element.Field))
		  	{
		  		element.show = false;
		  	}
		  }

		  
		  element.field = element.Field;
		  element.sortable = element.Field;	  


		  if(element.Key == "MUL")
		  {		  		
		  		var request = ajax_resource.foreign_data(element.Field);
		  		request.then(function(response){
		  			element.key_data = response.data.f_data[0];
		  			var foreign_object = $scope[element.key_data.REFERENCED_TABLE_NAME.capitalize()];
		  			element.title = foreign_object.default+" ("+foreign_object.table+")";
		  		});
		  }
		  else
		  {

		  	element.title = element.Field;

		 	var filter_obj = {};	 	  
			  
			if(element.Type.includes("int")||element.Type.includes("number"))
			{
				var filter_type = "number";		  
			}
			else
			{
			   var filter_type = "text";
			}

		 	filter_obj[element.field] = filter_type; 	 	  
		 	element.filter= filter_obj;
		 	 
		  }//console.log(element);		  

		});
		
		return this;
	}
