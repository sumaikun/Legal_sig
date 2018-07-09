app.controller('CrudController',['$scope','$timeout','CrudServices','SystemServices','$window','$compile','$filter','NgTableParams',function($scope,$timeout,CrudServices,SystemServices,$window,$compile,$filter,NgTableParams){

	//$scope.centros_cabecera = [{"title":"id"},{"title":"nombre"},{"title":"opciones"}];

	$(".loading").show();

	var self = this;

	var gsd = new get_session_data({resource:SystemServices});

	gsd.execute();

	//$scope.Session = gsd.output();

	async function f1() {
  		var x = await gsd.output(10);
  		$scope.Session = x.user_properties;
  		console.log($scope.Session);
	}

	f1();
	
	$scope.table_selected = {};

	$scope.new_element = {};

	$scope.Tipo_matriz = new table('Tipo_matriz',CrudServices,null,false);		

	$scope.Factores = new table('Factores',CrudServices,null,false);	

	$scope.Categorias = new table('Categorias',CrudServices,null,false);
	
	$scope.Tipo_norma = new table('Tipo_norma',CrudServices,null,false);

	$scope.Autoridad_emisora = new table('Autoridad_emisora',CrudServices,null,false);

	$scope.Emision = new table('Emision',CrudServices,null,false);

	$scope.Estados_vigencia = new table('Estados_vigencia',CrudServices,null,false);

	$scope.Normas = new table('Normas',CrudServices,null,false);	

	$scope.Articulos = new table('Articulos',CrudServices,null,false);	

	$scope.Literales = new table('Literales',CrudServices,null,false);	

	

	(function() {

		  

		  var tables_array = [$scope.Tipo_matriz,$scope.Factores,$scope.Categorias,$scope.Normas,$scope.Articulos,
		  $scope.Literales,$scope.Tipo_norma,$scope.Autoridad_emisora,$scope.Emision,$scope.Estados_vigencia];

		  

		  var promises = [];

		  tables_array.forEach(function(table_array){
		  		promises = promises.concat(table_array.loaded); 
		  });

		  console.log(promises);		  		  


		  
		  Promise.all(promises).then(values => {		  	  			  	   
			  ready_to_make_views();
		  });

	}());


	

	var ready_to_make_views = function(){
		

		$scope.factores_view = $scope.Factores.ng_table_adapter(["id","nombre","id_Tipo_matriz"]);
		//console.log($scope.factores_view);
		$scope.factores_view.ng_table_adapter_filter([{column:"id_Tipo_matriz",typefilter:"select"}]);

		$scope.factores_view.crudcontrol([{title:'Editar',action:'edit',icon:'edit',role:[1,2]},{title:'eliminar',action:'delete_replace',icon:'trash',role:[1]}]);

		$scope.categorias_view = $scope.Categorias.ng_table_adapter(["id","nombre","id_Factores"]);
		//console.log($scope.factores_view);
		$scope.categorias_view.ng_table_adapter_filter([{column:"id_Factores",typefilter:"select"}]);

		$scope.categorias_view.crudcontrol([{title:'Editar',action:'edit',icon:'edit',role:[1,2]},{title:'eliminar',action:'delete_replace',icon:'trash',role:[1]}]);

		$scope.autoridad_emisora_view = $scope.Autoridad_emisora.ng_table_adapter(["id","nombre"]);
		
		$scope.autoridad_emisora_view.crudcontrol([{title:'Editar',action:'edit',icon:'edit',role:[1,2]},{title:'eliminar',action:'delete_replace',icon:'trash',role:[1]}]);

		$scope.emision_view = $scope.Emision.ng_table_adapter(["id","year"]);
		
		$scope.emision_view.crudcontrol([{title:'Editar',action:'edit',icon:'edit',role:[1,2]},{title:'eliminar',action:'delete_replace',icon:'trash',role:[1]}]);

		$scope.tipo_norma_view = $scope.Tipo_norma.ng_table_adapter(["id","nombre"]);

		$scope.tipo_norma_view.crudcontrol([{title:'Editar',action:'edit',icon:'edit',role:[1,2]},{title:'eliminar',action:'delete_replace',icon:'trash',role:[1]}]);

		$scope.normas_view = $scope.Normas.ng_table_adapter(["id","numero","id_Tipo_norma","id_Emision","id_Autoridad_emisora","id_Estados_vigencia"]);
		
		$scope.normas_view.ng_table_adapter_filter([{column:"id_Tipo_norma",typefilter:"select"},{column:"id_Emision",typefilter:"select"},{column:"id_Autoridad_emisora",typefilter:"select"},{column:"id_Estados_vigencia",typefilter:"select"}]);		

		$scope.normas_view.crudcontrol([{title:'Editar',action:'edit',icon:'edit',role:[1,2]},{title:'eliminar',action:'delete_replace',icon:'trash',role:[1]},{title:'Derogar',action:'derogar',icon:'cube',role:[1,2],condition:{column:"id_Estados_vigencia",type:"equal",value:1}},{title:'Remover derogación',action:'desderogar',icon:'cube',role:[1,2],condition:{column:"id_Estados_vigencia",type:"equal",value:2}},{title:'Verificar Información de derogación',action:'verificacion_derogar',icon:'address-book',role:[1,2],condition:{column:"id_Estados_vigencia",type:"equal",value:2}}]);

		$scope.articulos_view = $scope.Articulos.ng_table_adapter(["id","numero","id_Normas","id_Estados_vigencia"]);

		$scope.articulos_view.ng_table_extra_foreigns_columns([{model:"Normas",columns:["id_Tipo_norma","id_Emision","id_Autoridad_emisora"]}]);

		$scope.articulos_view.ng_table_adapter_filter([{column:"id_Estados_vigencia",typefilter:"select"},{column:"id_Tipo_norma",typefilter:"select"},{column:"id_Emision",typefilter:"select"},{column:"id_Autoridad_emisora",typefilter:"select"}]);

		$scope.articulos_view.crudcontrol([{title:'Editar',action:'edit',icon:'edit',role:[1,2]},{title:'eliminar',action:'delete_replace',icon:'trash',role:[1]},{title:'Derogar',action:'derogar',icon:'cube',role:[1,2],condition:{column:"id_Estados_vigencia",type:"equal",value:1}},{title:'Verificar Información de derogación',action:'verificacion_derogar',icon:'address-book',role:[1,2],condition:{column:"id_Estados_vigencia",type:"equal",value:2}},{title:'Remover derogación',action:'desderogar',icon:'cube',role:[1,2],condition:{column:"id_Estados_vigencia",type:"equal",value:2}}]);
	
		alert("tablas cargadas");
		$(".loading").hide();		
	}
	

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
		  		
	  			var foreign_object = $scope[element.key_data.REFERENCED_TABLE_NAME.capitalize()];
	  			element.title = foreign_object.default+" ("+foreign_object.table+")";
		  		
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


	select_table = function()
	{	
		$(".loading").show();
		console.log("Changed");
		console.log($("#table_selected").val());		
		if($("#table_selected").val() != null)
		{			
			$scope.current_view =  $scope[$("#table_selected").val()+"_view"];
			console.log($scope.current_view.rows);
			self.Ngcrudtable = new NgTableParams({},{ dataset: $scope.current_view.rows});
			var reload = self.Ngcrudtable.reload();
			reload.then(function(res){
				console.log(self.Ngcrudtable);
				$(".loading").hide();


			});
			
			//						
		}

		
	}

	$scope.column_behavior = function(col,element)
	{	
		//console.log(col.Key);	
		if(col.Key != "")
		{
			return false;
		}

		return true;
		
	}


	$scope.edit = function(row,model)
	{
		//console.log(row);		
		model.update(row);		
	}
	
	$scope.delete = function(row,model)
	{	
		model.delete(row,self.Ngcrudtable);	
	}
	
	$scope.create = function(row,model)
	{
		//console.log(row);
		if(isEmpty(row))
		{
			return alert("No puede crear datos con valores vacios");
		}
		else
		{
			model.create(row,$scope.copycat);
		}
	}

	$scope.execute_action = function(row,model,action)
	{
		console.log(action);
		   switch (action) {
			    case "edit":
			        $scope.edit(row,model);
			        break;
			    case "delete":    
			    	$scope.delete(row,model);
			    	break;
			    case "delete_replace":
			    	$scope.delete_replace(row,model);
			    	break;
			    case "derogar":
			    	$scope.derogar(row,model);
			    	break;
			    case "desderogar":
			    	$scope.desderogar(row,model);
			    	break;
			    case "verificacion_derogar":
			    	$scope.verificacion_derogar(row,model);
			    	break;
			    default:
			    	alert("Acción no definida");
			    	break;
			}
	}
	          

	$scope.dynamicSelectArray = function(name){
	
		$scope.key_value =  $scope[name.capitalize()].default;
    	return $scope[name.capitalize()].rows;
	}

	$scope.foreign_value = function(key_data,f_id){
	
		var filter_object = {};
		filter_object[key_data.REFERENCED_COLUMN_NAME] = f_id;
		var foreign_data = $filter('filter')($scope[key_data.REFERENCED_TABLE_NAME.capitalize()].rows,filter_object)[0];		
		return foreign_data[$scope[key_data.REFERENCED_TABLE_NAME.capitalize()].default];
	}

	$scope.foreign_extra_value = function(row,col)
	{		
		var filter_object = {};
		filter_object[col.local_column.REFERENCED_COLUMN_NAME] = row[col.local_column.COLUMN_NAME];
		var foreign_data = $filter('filter')($scope[col.local_column.REFERENCED_TABLE_NAME.capitalize()].rows,filter_object)[0];
		return foreign_data[col.foreign_column.COLUMN_NAME];			
	}

	$scope.delete_replace = function(row,model)
	{
		
		this.output = function(){
			
			var table_model = model;	
			var request = SystemServices.replace_delete({id:row[model.primary_key],foid:$scope.modal.TableModal.radio_value,table:model.table});
				request.then(function(response){
				if(response.data.status!= null)
				{
					alert(response.data.message);
					if(response.data.status == 1)
					{
						var index = table_model.rows.indexOf(row);
						model.rows.splice(index, 1);
						$scope.reload_ngtable("Ngcrudtable");
					}	
						$("#AbstractModal").modal("hide");	
										
				}
				else
				{
					alert("Ocurrio un error inesperado");	
				}
			});
		}

		var ma = new make_confirm({text:"¿Desea Reemplazar los datos asociados a este registro con otro de la tabla "+model.table+" antes de eliminarlo?"});
		ma.init();
		ma.execute();
		output = ma.output();
		if(output == true)
		{
			var table_name = model.table;

			var table_columns = angular.copy(model.columns);

			var filter_object = {Field:"Opciones"};
			console.log(table_columns);
			var col = $filter('filter')(table_columns,filter_object)[0];
			console.log(col);
			var index = table_columns.indexOf(col);
			console.log(index);
			table_columns.splice(index, 1);		
			console.log(table_columns);

			var inner_output = this.output;

			var om =  new open_modal({title:"Registro con cual Reemplazar",size:"modal-lg",content:"table_in_modal",TableModal:{buttonname:"Reemplazar",action:"radio_row_from_table",id_in_radio:true,columns:table_columns,callback:inner_output}});
			om.execute();
			$scope.modal = om.output();

			if($scope.modal)
			{				
				self.ModalNgtable = new NgTableParams({},{ dataset: model.rows});
			}
			
		}
		if(output == false )
		{
			$scope.delete(row,model);
		}

		//var a = new select_in_modal({dataset:,action:""});
	}


	$scope.verificacion_derogar = function(row,model)
	{
		var request = SystemServices.derogar_info({id:row[model.primary_key],table:model.table});
		var iafr = new info_alert_from_request({service:SystemServices,ajaxmethod:request});
		iafr.execute();		
		iafr.output();
	}


	$scope.desderogar = function(row,model)
	{
		this.output = function(){
			
			var table_model = model;	
			var request = SystemServices.desderogar({id:row[model.primary_key],table:model.table});
				request.then(function(response){
				if(response.data.status!= null)
				{
					row.id_Estados_vigencia = 1;
					$scope.reload_ngtable("Ngcrudtable");
					$("#AbstractModal").modal("hide");
				}
				else
				{
					alert("Ocurrio un error inesperado");	
				}
			});
		}

			var ma = new make_confirm({text:"¿Esta seguro de cancelar la derogación de este registro?"});
			ma.init();
			ma.execute();
			output = ma.output();
			if(output == 1)
			{
				this.output();
			}
	}

	$scope.derogar = function(row,model)
	{
		//console.log(col);
		this.output = function(){
			
			var table_model = model;	
			var request = SystemServices.derogar({id:row[model.primary_key],foid:$scope.modal.TableModal.radio_value,table:model.table});
				request.then(function(response){
				if(response.data.status!= null)
				{
					row.id_Estados_vigencia = 2;
					$scope.reload_ngtable("Ngcrudtable");
					$("#AbstractModal").modal("hide");
				}
				else
				{
					alert("Ocurrio un error inesperado");	
				}
			});
		}

		var obp = new one_object_property({property:"id_Estados_vigencia",object:row});
		obp.init();
		obp.execute();

		output = obp.output();

		if(output == 1)
		{
			var ma = new make_confirm({text:"¿Esta seguro de derogar este registro?"});
			ma.init();
			ma.execute();
			output = ma.output();
			if(output == 1)
			{
				alert("Proceda a ingresar el registro con el cual derogarlo");
				var table_name = model.table;

				var table_columns = angular.copy(model.columns);

				var filter_object = {Field:"Opciones"};
	
				var col = $filter('filter')(table_columns,filter_object)[0];
				
				var index = table_columns.indexOf(col);
				
				table_columns.splice(index, 1);		
				

				var inner_output = this.output;

				var om =  new open_modal({title:"Registro con cual Reemplazar",size:"modal-lg",content:"table_in_modal",TableModal:{buttonname:"Reemplazar",action:"radio_row_from_table",id_in_radio:true,columns:table_columns,callback:inner_output}});
				om.execute();
				$scope.modal = om.output();

				if($scope.modal)
				{				
					self.ModalNgtable = new NgTableParams({},{ dataset: model.rows});
				}
				
			}
			else{
				alert("Este elemento no se puede derogar");
			}
		
		}
		

		
	}




	$scope.reload_ngtable = function(ngtable)
	{
		self[ngtable].reload();
	}

	get_element_by_index = function(columns,index,value)
	{
		var return_column;
		columns.forEach(function(element){
			console.log(element[index]);
			if(element[index] == value)
			{
				return_column = element;
			}
		});

		return return_column;
	}

	


	$scope.Test_callbacks = function()
	{

		$("#AbstractModal").modal("show");		
	}


	$scope.modal_action = function(action,callback)
	{
		var ma = new make_confirm({text:"¿Esta seguro de continuar?"});
		ma.init();
		ma.execute();
		output = ma.output();

		if(output)
		{
			switch(action){
				case "radio_row_from_table":
					console.log(callback);
					callback(self.ModalNgtable);
					
				break;
				default:
				break;
			}	
		}
		
	}
	
	$scope.check_session_action = function(role)
	{
		
		if(role.contains($scope.Session.rol))
		{
			//console.log("true");
			return true;
		}
		else
		{
			//console.log("false");
			return false;
		}
	}

	$scope.session_roles = function(roles)
	{
		if(roles.contains($scope.Session.rol))
		{
			//console.log("true");
			return true;
		}
		else
		{
			//console.log("false");
			return false;
		}	
	}

	$scope.evaluate_column_conditions = function(condition,row)
	{
		//console.log(row);
		if(condition == null)
		{
			return true;
		}
		else
		{

			if(condition.column != null)
			{
				//console.log(condition);
				switch(condition.type){
					case "equal":
						//console.log(row[condition.column]);
						//console.log(condition.value);
						if(row[condition.column] == condition.value)
						{
							return true;		
						}
						else
						{
							return false;
						}
						break;
					default:
					break;
				}

				return false;

			}
		}
	}

	$scope.render_edit = function(data)
	{
		if($scope.session_roles(data.roles))
		{
			return true;
		}
	}

	$scope.isWatching = function()
	{
		//console.log("is watching");
		return true;
	}


	create_filter_object = function(key_data)
	{
		//console.log(key_data);
		var array = [];
		var column_default = $scope[key_data.REFERENCED_TABLE_NAME.capitalize()].default;
		$scope[key_data.REFERENCED_TABLE_NAME.capitalize()].rows.forEach(function(row){
			var object_push = {};			
			object_push.id = row[key_data.REFERENCED_COLUMN_NAME];
			object_push.title = row[column_default];
			array.push(object_push);
		});
		//console.log(array);
		return array;
	}

		

}]);


var info_alert_from_request = function(properties)
{
	this.ajaxmethod = properties.ajaxmethod;
	this.async_process = "";
	//console.log(this.ajaxmethod);
	this.execute = function(){
		self = this;
		this.async_process = new Promise(function(resolve, reject) {
			self.ajaxmethod.then(function(response)
			{
				self.message = response.data.message;
				resolve(response.data.message);
			});
			self.ajaxmethod.catch(function(response) {
			  alert("ocurrio un error");
			  console.error('Gists error', response.status, response.data);
			  reject("error");
			});
		});			
	}

	this.output = function(){
		//console.log(this);
		this.async_process.then(function(res){
			alert(res);	
		});
		
	}
}



var open_modal = function(properties)
{	
	this.size = properties.size;
	this.title = properties.title;	
	this.content = properties.content;
	
	if(properties.SelectModal != null)
	{
		this.SelectModal = properties.SelectModal;
	}

	if(properties.TableModal != null)
	{
		this.TableModal = properties.TableModal;
	}

	this.out = {};
	this.execute = function(){
		$("#AbstractModal").modal("show");
		this.out = this;
	};
	this.output = function(){
		return this.out;
	}
	
}

var one_object_property = function(properties)
{
	this.property = properties.property;
	this.object = properties.object;
	this.out = {};
	this.execute = function()
	{
		this.out = this.object[this.property];
	}
	this.output = function(){
		return this.out;
	}
}


var select_in_modal = function(properties)
{	
	this.dataset = properties.dataset;
	this.action = properties.action;
	this.out = [];
	this.execute = function()
	{	
		var myself = this;	
		this.dataset.rows.forEach(function(row){
			var inner_object = {};
			inner_object["value"] = row[myself.dataset.primary_key];
			inner_object["option"] = row[myself.dataset.default];
			myself.out.push(inner_object);
		});
	}
	this.output = function(){
		return this.out;
	} 
} 

var make_confirm = function(properties)
{
	this.description = "Metodo para realizar ventanas de alerta";	
	this.text = properties.text;
	this.out = {};
	this.execute = function(){
		this.out = confirm(this.text);
	};
	this.output = function(){
		return this.out;
	};

}

var get_session_data = function(properties)
{
	this.description = "conseguir datos de sesión";	
	this.resource = properties.resource;
	this.out = {};
	var request = {};
	var self = this;
	this.execute = function(){		  
	   request = self.resource.get_sessions();				
	};
	this.output = function(){
		return new Promise(function(resolve, reject) {
				 request.then(function(response) {
				   resolve(response.data);
				}, function(err) {
				   err;
				});		
			});		
	};	
		
} 


make_confirm.prototype = new action();
select_in_modal.prototype = new action();
open_modal.prototype = new action();
one_object_property.prototype = new action();
get_session_data.prototype = new action();
info_alert_from_request.prototype = new action();
/*
var ma = new action("make_confirm",{text:"¿Desea reemplazarlo con otro antes de eliminarlo?"});
var om = new action("open_modal",{size:"modal-lg"});

var array_process = [ma,om];*/

$(document).ready(function(){
  	
  	$(document).on("focus", "#dynamicTable input[type='number']", function() {
    	console.log("triggered");
        	$(this).attr('autocomplete', 'off');
    	
	});

	$(document).on("focus", "#dynamicTable input[type='text']", function() {
    	console.log("triggered");
        	$(this).attr('autocomplete', 'off');
    	
	});

});