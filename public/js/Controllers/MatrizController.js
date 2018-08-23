(function() {
  "use strict";

	app.filter("MatrizFilter", MatrizFilter);
	 
	  
	  MatrizFilter.$inject = ["$filter","$rootScope"];
	  
	    function MatrizFilter($filter,$rootScope){

	      return function(data, Criteria){
	        
	        console.log(Criteria);

	      	if(Criteria.id_Categorias)
	      	{
	      		
	      		if(typeof(Criteria.id_Categorias) == "string")
	      		{
	      			var generate_array = [];	      		
	      		
		      		var scope_categorias = getfromScope("#matrizscope","Categorias");

		      		scope_categorias.rows.forEach(function(subelement){
		      			
		      			if(subelement.nombre.toUpperCase().startsWith(Criteria.id_Categorias.toUpperCase()))
		      			{
		      				generate_array.push(subelement.id);
		      			}

		      		});
		      		Criteria.id_Categorias = generate_array;
	      		}      		

	      	}

	      	if(Criteria.id_Articulos)
	      	{
	      		
	      		var generate_array = [];	      		
	      		
	      		var scope_articulos = getfromScope("#matrizscope","Articulos");
	      		
	      		scope_articulos.rows.forEach(function(subelement){
	      			
	      			if(subelement.numero.toString().startsWith(Criteria.id_Articulos.toString()))
	      			{
	      				generate_array.push(subelement.id);
	      			}
	      		});

	      		Criteria.id_Articulos = generate_array;

	      	}

	      	if(Criteria.id_Tipo_matriz)
	      	{
	      		var generate_array = [];	      	

	      		var scope_factores = getfromScope("#matrizscope","Factores");

	      		var factores = $filter('filter')(scope_factores.rows,function(value){
        			return value.id_Tipo_matriz === Criteria.id_Tipo_matriz;
				});

	      		var data_to_filter = [{id:"",title:""}];

	      		factores.forEach(function(factor){
	      		    
	      			data_to_filter.push({id:factor.id,title:factor.nombre});	      			

	      		    var scope_categorias = 	getfromScope("#matrizscope","Categorias");
	      			
	      			var categorias = $filter('filter')(scope_categorias.rows,function(value){
        				return value.id_Factores === factor.id;
					});	      			

	      			categorias.forEach(function(categoria){
	      				generate_array.push(categoria.id);
	      			});

      			});

      			accessScope('#matrizscope', function (scope) {
				    
				    if(data_to_filter != scope.factores_select)
				    {
				    	scope.factores_select = data_to_filter;
				    }			     	
				         
			    });
      			
      			Criteria.id_Tipo_matriz = generate_array;
	      	}

	      	if(Criteria.id_Factores)
	      	{
	      		if(typeof(Criteria.id_Factores) == "string")
	      		{
	      			var foreign_array = [];	      		
	      		
		      		var scope_factores = getfromScope("#matrizscope","Factores");

		      		scope_factores.rows.forEach(function(subelement){
		      			
		      			if(subelement.nombre.toUpperCase().startsWith(Criteria.id_Factores.toUpperCase()))
		      			{
		      				foreign_array.push(subelement.id);
		      			}

		      		});		      	

		      		var generate_array = [];

		      		var scope_categorias = getfromScope("#matrizscope","Categorias");

		      		scope_categorias.rows.forEach(function(subelement){
		      			
		      			if(foreign_array.includes(subelement.id_Factores))
		      			{
		      				generate_array.push(subelement.id);
		      			}

		      		});

		      		Criteria.id_Factores = generate_array;
	      		}
	      		else
	      		{ 	
		      		var generate_array = [];
		      		var scope_categorias = 	getfromScope("#matrizscope","Categorias");
		      		var categorias = $filter('filter')(scope_categorias.rows,function(value){
	        				return value.id_Factores === Criteria.id_Factores;
					});

		      		var data_to_filter = [{id:"",title:""}];

					categorias.forEach(function(categoria){
	      				
	      				data_to_filter.push({id:categoria.id,title:categoria.nombre});

	      				generate_array.push(categoria.id);
	      			});

	      			accessScope('#matrizscope', function (scope) {
					    
					    if(data_to_filter != scope.categorias_select)
					    {
					    	scope.categorias_select = data_to_filter;
					    }			     	
					         
				    });

	      			Criteria.id_Factores = generate_array;
      			}
	      	}

	      	if(Criteria.id_Tipo_norma)
	      	{
				var foreign_array = [];	      		
	      		
	      		var scope_tipo_norma = getfromScope("#matrizscope","Tipo_norma");

	      		scope_tipo_norma.rows.forEach(function(subelement){
	      			
	      			if(subelement.nombre.toUpperCase().startsWith(Criteria.id_Tipo_norma.toUpperCase()))
	      			{
	      				foreign_array.push(subelement.id);
	      			}

	      		});

	      		var foreign2_array = [];

	      		var scope_normas = getfromScope("#matrizscope","Normas");

	      		scope_normas.rows.forEach(function(subelement){
	      			
	      			if(foreign_array.includes(subelement.id_Tipo_norma))
	      			{
	      				foreign2_array.push(subelement.id);
	      			}

	      		});

	      		var generate_array = [];

	      		var scope_articulos = getfromScope("#matrizscope","Articulos");

	      		scope_articulos.rows.forEach(function(subelement){
	      			
	      			if(foreign2_array.includes(subelement.id_Normas))
	      			{
	      				generate_array.push(subelement.id);
	      			}

	      		});

	      		Criteria.id_Tipo_norma = generate_array;	      		
	      	}

	      	if(Criteria.id_Normas)
	      	{
				var scope_normas = getfromScope("#matrizscope","Normas");

				var foreign_array = [];

	      		scope_normas.rows.forEach(function(subelement){
	      			
	      			if(subelement.numero.toString().toUpperCase().startsWith(Criteria.id_Normas.toUpperCase()))
	      			{
	      				foreign_array.push(subelement.id);
	      			}

	      		});

	      		var generate_array = [];

	      		var scope_articulos = getfromScope("#matrizscope","Articulos");

	      		scope_articulos.rows.forEach(function(subelement){
	      			
	      			if(foreign_array.includes(subelement.id_Normas))
	      			{
	      				generate_array.push(subelement.id);
	      			}

	      		});

	      		Criteria.id_Normas = generate_array;

	      	}

	      	if(Criteria.id_Emision)
	      	{
				var foreign_array = [];	      		
	      		
	      		var scope_emision = getfromScope("#matrizscope","Emision");

	      		scope_emision.rows.forEach(function(subelement){
	      			
	      			if(subelement.year.toString().toUpperCase().startsWith(Criteria.id_Emision.toString().toUpperCase()))
	      			{
	      				foreign_array.push(subelement.id);
	      			}

	      		});

	      		var foreign2_array = [];

	      		var scope_normas = getfromScope("#matrizscope","Normas");

	      		scope_normas.rows.forEach(function(subelement){
	      			
	      			if(foreign_array.includes(subelement.id_Emision))
	      			{
	      				foreign2_array.push(subelement.id);
	      			}

	      		});

	      		var generate_array = [];

	      		var scope_articulos = getfromScope("#matrizscope","Articulos");

	      		scope_articulos.rows.forEach(function(subelement){
	      			
	      			if(foreign2_array.includes(subelement.id_Normas))
	      			{
	      				generate_array.push(subelement.id);
	      			}

	      		});

	      		Criteria.id_Emision = generate_array;	      		
	      	}

	      	if(Criteria.id_Autoridad_emisora)
	      	{
				var foreign_array = [];	      		
	      		
	      		var scope_autoridad = getfromScope("#matrizscope","Autoridad_emisora");

	      		scope_autoridad.rows.forEach(function(subelement){
	      			
	      			if(subelement.nombre.toString().toUpperCase().startsWith(Criteria.id_Autoridad_emisora.toString().toUpperCase()))
	      			{
	      				foreign_array.push(subelement.id);
	      			}

	      		});

	      		var foreign2_array = [];

	      		var scope_normas = getfromScope("#matrizscope","Normas");

	      		scope_normas.rows.forEach(function(subelement){
	      			
	      			if(foreign_array.includes(subelement.id_Autoridad_emisora))
	      			{
	      				foreign2_array.push(subelement.id);
	      			}

	      		});

	      		var generate_array = [];

	      		var scope_articulos = getfromScope("#matrizscope","Articulos");

	      		scope_articulos.rows.forEach(function(subelement){
	      			
	      			if(foreign2_array.includes(subelement.id_Normas))
	      			{
	      				generate_array.push(subelement.id);
	      			}

	      		});

	      		Criteria.id_Autoridad_emisora = generate_array;	      		
	      	}	

	      	if(Criteria.id_Estados_vigencia)
	      	{
	      		var generate_array = [];

	      		var scope_articulos = getfromScope("#matrizscope","Articulos");

	      		scope_articulos.rows.forEach(function(subelement){
	      			
	      			if(subelement.id_Estados_vigencia == Criteria.id_Estados_vigencia)
	      			{
	      				generate_array.push(subelement.id);
	      			}

	      		});

	      		Criteria.id_Estados_vigencia = generate_array;
	      	}	


	      	console.log(Criteria);

	      	var Connections =  [{criteriaindex:"id_Tipo_matriz",itemindex:"id_Categorias"},
	      	{criteriaindex:"id_Factores",itemindex:"id_Categorias"},{criteriaindex:"id_Tipo_norma",itemindex:"id_Articulos"},
	      	{criteriaindex:"id_Normas",itemindex:"id_Articulos"},{criteriaindex:"id_Emision",itemindex:"id_Articulos"},
	      	{criteriaindex:"id_Autoridad_emisora",itemindex:"id_Articulos"},{criteriaindex:"id_Estados_vigencia",itemindex:"id_Articulos"}];
	        
	        var Exact_number_properties =  ["id_empresa","id_Categorias","id_clase_norma"];

	        return (data || []).filter(function(item){        
	          /*if(dynamic_conditions(Criteria,item,Connections,Exact_number_properties))
	          {
	             console.log(item);
	          }*/
	          return dynamic_conditions(Criteria,item,Connections,Exact_number_properties);
	        	
	      	  });
	    	};

	    	function dynamic_conditions(Criteria,item,Connections,Exact_number_properties)
			{

			    var validations = true;
			    for(var property in Criteria){			     
			      	
			      var itemproperty = property;
			      
			      

			      var check_connections = $filter('filter')(Connections,
			      	function(value){
	        				return value.criteriaindex === property}
    				)[0];			      
			      
			      if(check_connections != null)
			      {
			      	 var itemproperty = check_connections.itemindex;	
			      }
			      
			      if(typeof(Criteria[property]) == "object" )
			      {      
			        validations = Criteria[property].indexOf(item[itemproperty]) !== -1 ? true : false;
			      }
			      if(typeof(Criteria[property]) == "number" )
			      {
			      	if(item[itemproperty] != null){

				      	if(Exact_number_properties.indexOf(property)!== -1 )
				      	{
				      		validations =  item[itemproperty] == Criteria[property] ? true : false; 
				      	}
				      	else
				      	{
				      		//console.log(item[itemproperty]);
				      		//console.log(itemproperty);				      		
				      		validations = item[itemproperty].toString().startsWith(Criteria[property]) ? true : false;	
				      	}			      			
			      	}		                 
			      } 
			      if(typeof(Criteria[property]) == "string" )
			      {		        
			        if(item[itemproperty] != null){
			        	validations = item[itemproperty].toUpperCase().startsWith(Criteria[property].toUpperCase()) ? true : false;
			        }        
			      }

			      if(!validations){return false;}      
			    }

			    return true; 
			}
		}
		
})();

app.controller('MatrizController',['$scope','$timeout','CrudServices','SystemServices','$window','$compile','$filter','NgTableParams',function($scope,$timeout,CrudServices,SystemServices,$window,$compile,$filter,NgTableParams){



	$(".loading").show();

	var self = this;

	var gsd = new get_session_data({resource:SystemServices});

	gsd.execute();

	//$scope.test = "triggered in controller";

	async function f1() {
  		var x = await gsd.output(10);
  		$scope.Session = x.user_properties;
  		console.log($scope.Session);
	}

	f1();

	window.dev_data = {}; 
	
	$scope.table_selected = {};

	$scope.new_element = {};

	$scope.Empresa = new table('Empresa',CrudServices,null,false);	

	$scope.Tipo_matriz = new table('Tipo_matriz',CrudServices,null,false);

	$scope.Clase_norma = new table('Clase_norma',CrudServices,null,false);		

	$scope.Factores = new table('Factores',CrudServices,null,false);	

	$scope.Categorias = new table('Categorias',CrudServices,null,false);	

	$scope.Tipo_norma = new table('Tipo_norma',CrudServices,null,false);

	$scope.Autoridad_emisora = new table('Autoridad_emisora',CrudServices,null,false);

	$scope.Emision = new table('Emision',CrudServices,null,false);

	$scope.Estados_vigencia = new table('Estados_vigencia',CrudServices,null,false);

	$scope.Normas = new table('Normas',CrudServices,null,false);	

	$scope.Articulos = new table('Articulos',CrudServices,null,false);	

	$scope.Literales = new table('Literales',CrudServices,null,false);

	$scope.Requisitos = new table('Requisitos',CrudServices,null,false);	

	(function() {

		  var tables_array = [$scope.Tipo_matriz,$scope.Clase_norma,$scope.Factores,$scope.Categorias,$scope.Normas,$scope.Articulos,
		  $scope.Literales,$scope.Tipo_norma,$scope.Autoridad_emisora,$scope.Emision,$scope.Estados_vigencia
		  ,$scope.Requisitos];

		  

		  var promises = [];

		  tables_array.forEach(function(table_array){
		  		promises = promises.concat(table_array.ready); 
		  });

		  //console.log(promises);		  		  


		  
		  Promise.all(promises).then(values => {			  
			  
			  ready_to_make_views();
		  });

	}());


	

	var ready_to_make_views = function(){



		self.empresas_select = function()
		{
			array = [];
			$scope.Empresa.rows.forEach(function(row){
				var object_push = [];			
				object_push.id = row.idempresa;
				object_push.title = row.nombre;
				array.push(object_push);
			});

			return array; 	
		}

		self.tipos_matriz_select = function()
		{
			array = [];
			$scope.Tipo_matriz.rows.forEach(function(row){
				var object_push = [];			
				object_push.id = row.id;
				object_push.title = row.nombre;
				array.push(object_push);
			});

			return array; 	
		}

		self.estados_vigencia_select = function()
		{
			array = [];
			$scope.Estados_vigencia.rows.forEach(function(row){
				var object_push = [];			
				object_push.id = row.id;
				object_push.title = row.nombre;
				array.push(object_push);
			});

			return array; 	
		}

		self.clase_norma_select = function()
		{
			array = [];
			$scope.Clase_norma.rows.forEach(function(row){
				var object_push = [];			
				object_push.id = row.id;
				object_push.title = row.nombre;
				array.push(object_push);
			});

			return array; 	
		}

		$scope.factores_select = [];

		$scope.categorias_select = [];
		

		$scope.requisitos_view = $scope.Requisitos;  

		//$scope.requisitos_view = $scope.Requisitos.ng_table_adapter(["id","id_empresa","id_Categorias","id_Articulos","reqlegal","esperada"
			//,"responsable","area","nrelacionadas","id_clase_norma"]);

		//console.log($scope.requisitos_view);

		$scope.requisitos_view.columns.push({Field:"id_Normas",with:"id_Articulos",by:"id_Normas",get:"numero",KEY:"extra_column"});

		$scope.requisitos_view.columns.push({Field:"id_Tipo_norma",with:"id_Normas",by:"id_Tipo_norma",get:"nombre",KEY:"extra_column"});

		$scope.requisitos_view.columns.push({Field:"id_Emision",with:"id_Normas",by:"id_Emision",get:"year",KEY:"extra_column"});

		$scope.requisitos_view.columns.push({Field:"id_Autoridad_emisora",with:"id_Normas",by:"id_Autoridad_emisora",get:"nombre",KEY:"extra_column"});

		$scope.requisitos_view.columns.push({Field:"id_Factores",with:"id_Categorias",by:"id_Factores",get:"nombre",KEY:"extra_column"});

		$scope.requisitos_view.columns.push({Field:"id_Estados_vigencia",with:"id_Articulos",by:"id_Estados_vigencia",get:"nombre",KEY:"extra_column"});

		$scope.requisitos_view.columns.push({Field:"id_Tipo_matriz",with:"id_Factores",by:"id_Tipo_matriz",get:"nombre",KEY:"extra_column"});

		$scope.requisitos_view.headers = [
			{Field:"id",title:"id",filter:{id:"number"}},{Field:"id_empresa",title:"Empresa",filter:{id_empresa: 'select'},filterData:self.empresas_select},{Field:"id_Tipo_matriz",title:"Grupo/Tema",filter:{id_Tipo_matriz: 'select'},filterData:self.tipos_matriz_select},
			{Field:"id_Factores",title:"Factor riesgo",filter:{id_Factores: 'dynamic-select'},filterData:"factores_select"},{Field:"id_Categorias",title:"Categorias",filter:{id_Categorias: 'dynamic-select'},filterData:"categorias_select"},{Field:"id_Tipo_norma",title:"Tipo de norma",filter:{id_Tipo_norma:"text"}},
			{Field:"id_Normas",title:"Norma",filter:{id_Normas:"text"}},{Field:"id_Emision",title:"Fecha de emisión",filter:{id_Emision:"number"}},{Field:"id_Autoridad_emisora",title:"Autoridad emisora",filter:{id_Autoridad_emisora:"text"}},{Field:"id_Articulos",title:"Articulo",filter:{id_Articulos:"text"}},{Field:"id_Estados_vigencia",title:"Estado",filter:{id_Estados_vigencia:"select"},filterData:self.estados_vigencia_select},
			{Field:"reqlegal",title:"Requisito",filter:{reqlegal:"text"}},{Field:"esperada",title:"Evidencia esperada",filter:{esperada:"text"}},{Field:"responsable",title:"responsable",filter:{responsable:"text"}},
			{Field:"area",title:"Area",filter:{area:"text"}},{Field:"id_clase_norma",title:"Clase",filter:{id_clase_norma:"select"},filterData:self.clase_norma_select},{Field:"nrelacionadas",title:"Normas relacionadas",filter:{nrelacionadas:"text"}}
			];

		//console.log($scope.requisitos_view);		

		//$scope.requisitos_view.ng_table_extra_columns([{model:"Articulos",foreing_key:"id_Normas",foreign_model:"Normas",columns:["id_Normas"]}]);

		//console.log($scope.requisitos_view);

		//$scope.requisitos_view.ng_table_extra_foreigns_columns([{model:"Articulos",columns:["id_Normas"]},{model:"Normas",columns:["id_Tipo_norma","id_Emision","id_Autoridad_emisora"]}]);

		
		alert("Matriz cargada");
		$(".loading").hide();

		
		self.Ngtable = new NgTableParams({},{ 
		  filterOptions: {filterFilterName: "MatrizFilter"},
		  dataset: $scope.requisitos_view.rows});

		self.headers = $scope.requisitos_view.headers;

		self.columns = $scope.requisitos_view.columns;

		self.Ngtable.reload();
				
	}



	
	$scope.extra_column = function(columns,column,row)
	{
		//console.log(column);
		
		var with_column = $filter('filter')(columns,{Field:column.with})[0];
	
		if(with_column.KEY != "extra_column")
		{
			var with_model = $scope[with_column.key_data.REFERENCED_TABLE_NAME.capitalize()];

			//Por medio del key data accedo a la tabla de referencia esta a su vez me permite instanciar el modelo inmediato del
			//proceso y nuevamente buscando la columna por la que hace referencia retornar un valor.

			filter_obj = {}; filter_obj[with_column.key_data.REFERENCED_COLUMN_NAME] = row[column.with];		

			//console.log(filter_obj); 

			var with_row = $filter('filter')(with_model.rows,filter_obj)[0];
		}

		else
		{
			var get_from_indirect = $scope.extra_column(columns,with_column,row);

			var with_model = get_from_indirect.by_model;

			var with_row = get_from_indirect.get_row;

		}		

		//console.log(with_row);

		var by_column = $filter('filter')(with_model.columns,{Field:column.by})[0];
		
		var by_model = $scope[by_column.key_data.REFERENCED_TABLE_NAME.capitalize()];			

		//Estos modelos me permiten al modelo final para pasarle la referencia y traer valor solicitado

		filter_obj = {}; filter_obj[by_column.key_data.REFERENCED_COLUMN_NAME] = with_row[column.by];

		var get_row = $filter('filter')(by_model.rows,filter_obj)[0];

		return {by_model:by_model,get_row:get_row};
	}

	$scope.get_column_by_reference = function(header){
		var column = $filter('filter')(self.columns,{Field:header.Field})[0];
		//console.log(column);
		return column;
	}	
	
	table.prototype.ng_table_extra_foreigns_columns = function(columnarray)
	{
		var new_columns = [];
		var object = this;
				

		columnarray.forEach(function(element){
					
				var current_row = get_reference_model_name(object,element.model);

				//Nombre de modelo de referencia
				
				element.columns.forEach(function(subelement){
				
					var foreign_column = $filter('filter')($scope[element.model.capitalize()].columns,{Field:subelement})[0];
					
					//foreign row es la columna 

					new_column = {};
					new_column.Field = subelement;
					new_column.title = subelement+"("+element.model+")";
					new_column.Key = "FAKE_MUL";					
					new_column.key_data = foreign_column.key_data;
					new_column.foreign_column = foreign_column.key_data;
					new_column.local_column = foreign_column.key_data;

					//Aca hay 3 datos iguales que no les veo sentido

					object.columns.push(new_column);



					object.rows.forEach(function(row){
						row[subelement] = $scope.foreign_extra_value(row,new_column);
					});

				});
			});		
		
	}



	$scope.execute_action = function(row,model,action)
	{
		console.log(action);
		   switch (action.action) {
			 
			    default:
			    	alert("Acción no definida");
			    	break;
			}
	}
	          



	$scope.foreign_value = function(key_data,f_id,return_value = false){
	
		var filter_object = {};
		filter_object[key_data.REFERENCED_COLUMN_NAME] = f_id;
		//creo un objeto que tenga la columna de referencia

		var foreign_data = $filter('filter')($scope[key_data.REFERENCED_TABLE_NAME.capitalize()].rows,filter_object)[0];
		//Después busco el objeto y le regreso su valor por defecto	
		if(!return_value)
		{
			return foreign_data[$scope[key_data.REFERENCED_TABLE_NAME.capitalize()].default];
			//La razón de este codigo es para capturar el valor por defecto de forma dinámica	
		}
		else
		{			
			return 	foreign_data[return_value];
		}	
		
	}




	$scope.reload_ngtable = function(ngtable)
	{
		self[ngtable].reload();
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

	
	

	$scope.isWatching = function()
	{
		//console.log("is watching");
		return true;
	}




		

}]);


/*
var ma = new action("make_confirm",{text:"¿Desea reemplazarlo con otro antes de eliminarlo?"});
var om = new action("open_modal",{size:"modal-lg"});

var array_process = [ma,om];*/

$(document).ready(function(){
  	
  	$(document).on("focus", "#dynamicTable input[type='number']", function() {
    	//console.log("triggered");
        	$(this).attr('autocomplete', 'off');
    	
	});

	$(document).on("focus", "#dynamicTable input[type='text']", function() {
    	//console.log("triggered");
        	$(this).attr('autocomplete', 'off');
    	
	});

});

