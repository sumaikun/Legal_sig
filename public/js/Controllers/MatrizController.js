(function() {
  "use strict";

	app.filter("MatrizFilter", MatrizFilter);
	 
	  
	  MatrizFilter.$inject = ["$filter","$rootScope"];
	  
	    function MatrizFilter($filter,$rootScope){

	      return function(data, Criteria){
	        
	        //console.log(Criteria);

	        if(Criteria.id_empresa)
	      	{
	      		accessScope('#matrizscope', function (scope) {
				    
				  scope.enterprise_selected = Criteria.id_empresa;
				         
			    });
	      	}

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


	      	//console.log(Criteria);

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

app.controller('MatrizController',['$scope','$timeout','CrudServices','SystemServices','$window','$compile','$filter','NgTableParams','$http',function($scope,$timeout,CrudServices,SystemServices,$window,$compile,$filter,NgTableParams,$http){

	$scope.id_in_checkbox = true;

	$scope.selected_boxes = [];

	$scope.Evaluaciones = {};

	$scope.modal = {};

	$scope.var_generate = [];

	$scope.row_to_edit = {};

	$scope.enterprise_selected = "";

	var request_alredy_done = [];

	$scope.create_register = false;

	$(".loading").show();

	var self = this;

	var gsd = new get_session_data({resource:SystemServices});

	gsd.execute();

	//$scope.test = "triggered in controller";

	async function f1() {
  		var x = await gsd.output(10);
  		$scope.Session = x.user_properties;
  		
  		console.log($scope.Session);

  		if($scope.Session.rol == 1)
		{
			$scope.Requisitos = new table('Requisitos',CrudServices,null,false);	
			$scope.Empresa = new table('empresa',CrudServices,null,false);
		}
		else
		{
			$scope.Requisitos = new table('Requisitos',CrudServices,null,false,{id_empresa:$scope.Session.empresas});	
			$scope.Empresa = new table('empresa',CrudServices,null,false,{idempresa:$scope.Session.empresas});
		}			

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

		$scope.Extra_json_data = new table('Extra_json_data',CrudServices,null,false);
		

		


		(function() {

			  var tables_array = [$scope.Tipo_matriz,$scope.Clase_norma,$scope.Factores,$scope.Categorias,$scope.Normas,$scope.Articulos,
			  $scope.Literales,$scope.Tipo_norma,$scope.Autoridad_emisora,$scope.Emision,$scope.Estados_vigencia
			  ,$scope.Requisitos,$scope.Extra_json_data];

			  

			  var promises = [];

			  tables_array.forEach(function(table){
			  		promises = promises.concat(table.ready); 
			  });

			  //console.log(promises);		  		  


			  
			  Promise.all(promises).then(values => {			  
				  
				  ready_to_make_views();
			  });

		}());

	}

	f1();

	window.dev_data = {}; 
	
	$scope.table_selected = {};

	$scope.new_element = {};
	

	
	 $scope.$watch("enterprise_selected",function(newValue,oldValue) {
     	
     	if(newValue == 3)
     	{
     		//alert("trigger");
     		self.headers.push({Field:"Requisito_proceso",title:"Requisitos en proceso",editable:true,Key:"json_columns"});
     		self.headers.push({Field:"Barranca",title:"Barranca",editable:true,Key:"json_columns"});
     		self.headers.push({Field:"Cota",title:"Cota",editable:true,Key:"json_columns"});
     		self.headers.push({Field:"Guafilla",title:"Guafilla",editable:true,Key:"json_columns"});
     		self.headers.push({Field:"Villavicencio",title:"Villavicencio",editable:true,Key:"json_columns"});
     		self.headers.push({Field:"Neiva",title:"Neiva",editable:true,Key:"json_columns"});
     		self.headers.push({Field:"Oficinas",title:"Oficinas",editable:true,Key:"json_columns"});
     		self.headers.push({Field:"Likelihood",title:"Likelihood",editable:true,Key:"json_columns"});
     		self.headers.push({Field:"Severity",title:"Severity",editable:true,Key:"json_columns"});
     		self.headers.push({Field:"Likelihood_X_Severity",title:"Likelihood X Severity",editable:true,Key:"json_columns"});
     		self.headers.push({Field:"Risk_Level",title:"Risk Level",editable:true,Key:"json_columns"}); 

     		//console.log($scope.requisitos_view);

     		self.Ngtable.reload();


     	}

     	if((oldValue != newValue))
     	{
     		$scope.selected_boxes = [];
     		UncheckAll();

     		if(oldValue == 3)
	     	{ 	
	     		array = ["Requisito_proceso","Barranca","Cota",
	     		"Guafilla","Villavicencio","Neiva","Oficinas",
	     		"Likelihood","Severity","Likelihood_X_Severity","Risk_Level"];
	     		
	     		array.forEach(function(value){
	     			row = $filter('filter')(self.headers,{Field:value})[0];
	     			index = self.headers.indexOf(row);
	     			self.headers.splice(index, 1);	
	     		});


	     		self.Ngtable.reload();
	     	}	
     		
     	}
	   
    });
	

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

		if($scope.Session.rol != 1)
		{
			$scope.enterprise_selected = $scope.Session.empresas[0]; 	
		}
		

		$scope.factores_select = [];

		$scope.categorias_select = [];
		
		//console.log($scope.Requisitos);

		$scope.requisitos_view = $scope.Requisitos;  

		$scope.requisitos_view.control([{title:'eliminar',action:'delete',icon:'trash',role:[1]},{title:'Evaluaciones',action:'get_evals',icon:'check',role:[1,2,3]}]);

		//$scope.requisitos_view = $scope.Requisitos.ng_table_adapter(["id","id_empresa","id_Categorias","id_Articulos","reqlegal","esperada"
			//,"responsable","area","nrelacionadas","id_clase_norma"]);

		//console.log($scope.requisitos_view);

				//console.log($scope.requisitos_view);		

		//$scope.requisitos_view.ng_table_extra_columns([{model:"Articulos",foreing_Key:"id_Normas",foreign_model:"Normas",columns:["id_Normas"]}]);

		//console.log($scope.requisitos_view);

		//$scope.requisitos_view.ng_table_extra_foreigns_columns([{model:"Articulos",columns:["id_Normas"]},{model:"Normas",columns:["id_Tipo_norma","id_Emision","id_Autoridad_emisora"]}]);


		$scope.requisitos_view.columns.push({Field:"id_Normas",with:"id_Articulos",by:"id_Normas",get:"numero",Key:"extra_column"});

		$scope.requisitos_view.columns.push({Field:"id_Tipo_norma",with:"id_Normas",by:"id_Tipo_norma",get:"nombre",Key:"extra_column"});

		$scope.requisitos_view.columns.push({Field:"id_Emision",with:"id_Normas",by:"id_Emision",get:"year",Key:"extra_column"});

		$scope.requisitos_view.columns.push({Field:"id_Autoridad_emisora",with:"id_Normas",by:"id_Autoridad_emisora",get:"nombre",Key:"extra_column"});

		$scope.requisitos_view.columns.push({Field:"id_Factores",with:"id_Categorias",by:"id_Factores",get:"nombre",Key:"extra_column"});

		$scope.requisitos_view.columns.push({Field:"id_Estados_vigencia",with:"id_Articulos",by:"id_Estados_vigencia",get:"nombre",Key:"extra_column"});

		$scope.requisitos_view.columns.push({Field:"id_Tipo_matriz",with:"id_Factores",by:"id_Tipo_matriz",get:"nombre",Key:"extra_column"});

		$scope.requisitos_view.headers = [
			{Field:"id",title:"id",filter:{id:"number"}},{Field:"id_empresa",title:"Empresa",filter:{id_empresa: 'select'},filterData:self.empresas_select},{Field:"id_Tipo_matriz",title:"Grupo/Tema",filter:{id_Tipo_matriz: 'select'},filterData:self.tipos_matriz_select},
			{Field:"id_Factores",title:"Factor riesgo",filter:{id_Factores: 'dynamic-select'},filterData:"factores_select"},{Field:"id_Categorias",title:"Categorias",filter:{id_Categorias: 'dynamic-select'},filterData:"categorias_select"},{Field:"id_Tipo_norma",title:"Tipo de norma",filter:{id_Tipo_norma:"text"}},
			{Field:"id_Normas",title:"Norma",filter:{id_Normas:"text"}},{Field:"id_Emision",title:"Fecha de emisión",filter:{id_Emision:"number"}},{Field:"id_Autoridad_emisora",title:"Autoridad emisora",filter:{id_Autoridad_emisora:"text"}},{Field:"id_Articulos",title:"Articulo",filter:{id_Articulos:"text"}},{Field:"id_Estados_vigencia",title:"Estado",filter:{id_Estados_vigencia:"select"},filterData:self.estados_vigencia_select},
			{Field:"reqlegal",title:"Requisito",filter:{reqlegal:"text"}},{Field:"esperada",title:"Evidencia esperada",filter:{esperada:"text"}},{Field:"responsable",title:"responsable",filter:{responsable:"text"}},
			{Field:"area",title:"Area",filter:{area:"text"}},{Field:"id_clase_norma",title:"Clase",filter:{id_clase_norma:"select"},filterData:self.clase_norma_select},{Field:"nrelacionadas",title:"Normas relacionadas",filter:{nrelacionadas:"text"}},{Field:"Opciones",title:"Opciones"}
		];

		
		alert("Matriz cargada");
		$(".loading").hide();

		
		self.Ngtable = new NgTableParams({},{ 
		  filterOptions: {filterFilterName: "MatrizFilter"},
		  dataset: $scope.requisitos_view.rows});

		self.headers = $scope.requisitos_view.headers;

		self.columns = $scope.requisitos_view.columns;

		self.tableModel = $scope.requisitos_view.table;

		self.Ngtable.reload();
				
	}

	$scope.placeholder_select = [{id:1,value:1},{id:2,value:2},{id:3,value:3}];

	$scope.idselectordynamicparam = {};
	$scope.valueselectordynamicparam = {};
	$scope.valueselecteddynamic = {};


	$scope.dynamicLinkedSelectArray = function(data){
	
		//$scope.key_value =  $scope[data.name.capitalize()].default;
    	//return $scope[name.capitalize()].rows;
    	//console.log(data.col);
    	//console.log(data.row);
    	if(data.col.Key == "extra_column")
    	{
    		var result = $filter('filter')(self.columns,{Field:data.col.Field,Key:"extra_column"});
			//console.log("valor asociado interno");			
			
			inner_data = $scope.extra_column(self.columns,result[0],data.row);			
			
	
			
			$scope.idselectordynamicparam[data.col.Field] = Object.keys(inner_data.get_row)[0];
			$scope.valueselectordynamicparam[data.col.Field] = $scope[inner_data.by_model.table].default;			
			

			$scope.valueselecteddynamic[data.row.id+data.col.Field] = inner_data.get_row[Object.keys(inner_data.get_row)[0]];
			 

			assoc_data = $filter('filter')(self.columns,{with:data.col.Field,Key:"extra_column"});
			
			if(assoc_data.length > 0)
			{
				build_obj = {};

				assoc_data.forEach(function(element){					
					build_obj[element.Field] = inner_data.get_row[element.Field];
				});
			
				return $filter('filter')($scope[inner_data.by_model.table].rows,function(value){
					return filter_exact_object_properties(build_obj,value);
				});
			}
			else
			{
				return $scope[inner_data.by_model.table].rows;	
			}			
		
			
		}
		else
		{
			
			assoc_data = $filter('filter')(self.columns,{with:data.col.Field,Key:"extra_column"});
			
			//console.log("datos de asociacion externos");
			//console.log(assoc_data);

			$scope.idselectordynamicparam[data.col.Field] = data.col.key_data.REFERENCED_COLUMN_NAME;
			
			$scope.valueselectordynamicparam[data.col.Field] = $scope[data.col.key_data.REFERENCED_TABLE_NAME.capitalize()].default;
			
			//console.log($scope.valueselectordynamicparam); 


			var obj_filter = {};
			obj_filter[data.col.key_data.REFERENCED_COLUMN_NAME] = data.row[data.col.Field]; 

			//console.log(obj_filter);				

			inner_data = $filter('filter')($scope[data.col.key_data.REFERENCED_TABLE_NAME.capitalize()].rows,function(value){
					return filter_exact_object_properties(obj_filter,value);				
			})[0];

			//console.log(inner_data);

			if(assoc_data.length > 0)
			{
				var build_obj = {};

				assoc_data.forEach(function(element){					
					build_obj[element.Field] = inner_data[element.Field];
				});

				/*console.log($filter('filter')($scope[data.col.key_data.REFERENCED_TABLE_NAME.capitalize()].rows,function(value){
					return filter_exact_object_properties(build_obj,value);
				}));*/

				return $filter('filter')($scope[data.col.key_data.REFERENCED_TABLE_NAME.capitalize()].rows,function(value){
					return filter_exact_object_properties(build_obj,value);
				});	
			}

			else
			{
				return $scope[data.col.key_data.REFERENCED_TABLE_NAME.capitalize()].rows;
									
			}	
		}	
			

		return $scope.placeholder_select;	
		

	}


	function filter_exact_object_properties(object,value)
	{ 		var check = false;
			for (var key in object) {
				if(object[key] == value[key])
				{
					check = true;
				}
				else
				{
					return false;	
				}
			}
			if(check){  return true; };		
	}

	// Generando variables
	$scope.generate_var = function(info)
	{
		if($scope.var_generate[info.varname] == null)
		{
			$scope.var_generate[info.varname] = {};	
		}

		$scope.var_generate[info.varname][info.index] = info.data; 
		//console.log(info.index);
		//console.log($scope.var_generate);
	}

	$scope.on_change_to_edit = function(data)
	{
		//console.log("clicked");
		//console.log(data);
		//console.log($("#"+data.id+data.field).val());
		//console.log($scope.var_generate['data_to_edit'+data.id]);
		//var selected_value = $("#"+data.id+data.field).val();

		//Guardar lo seleccionado		 

		index_selector = '#\\3'+data.id+data.field;
		var selected_value = document.querySelector(index_selector).value;		


		if($scope.valueselecteddynamic[data.id+data.field] != selected_value)
		{
			$scope.valueselecteddynamic[data.id+data.field] = selected_value;
			//Verficiar que el dato sea distinto al previamente seleccionado para evitar reprocesos.

			var direct_assoc =$filter('filter')(self.columns,{Field:data.field,Key:"extra_column"})[0];
			//reconocer asociacion directa

			var dataset_to_filter = [];
			var consequence_filter = [];

			if(direct_assoc != null)
			{
				var cont = true;
				while(cont)
				{
				
					//Conseguir llaves relacionadas
					var keys_to_filter = $filter('filter')(self.columns,{with:direct_assoc.with,Key:"extra_column"});

					var obj_to_filter = {};

					keys_to_filter.forEach(function(key){
						//console.log(key.Field);
						//console.log($scope.valueselecteddynamic[data.id+key.Field]);						
						obj_to_filter[key.Field] = $scope.valueselecteddynamic[data.id+key.Field];
					});		
					//--------------------------------------
					
					//Crear objetos para filtrar, pueden haber filtros de consecuencia, aquellos filtros que son resultados de otros resultados
					
					console.log(consequence_filter);	

					if(consequence_filter.length > 0)
					{
						dataset_to_filter = consequence_filter;
						consequence_filter = [];
					}
					else
					{
						dataset_to_filter.push(obj_to_filter);	
					}

					console.log(dataset_to_filter);
					 
					//---------------------------------------



					//Filtro principal
					$scope.var_generate['data_to_edit'+data.id][direct_assoc.with] = $filter('filter')($scope[direct_assoc.with.replace("id_","")].rows,function(value){
						var result = 0;
						dataset_to_filter.forEach(function(element){
							if(filter_exact_object_properties(element,value))
							{
								var obj_inner_filter = {};
								obj_inner_filter[direct_assoc.with] = value["id"];
								consequence_filter.push(obj_inner_filter);
								result++;	
							}
						});
						if(result>0){ return true; }else{ return false; }
						return false;
					});
					//

				
					//Validación para quitar ciclo	

					direct_assoc = $filter('filter')(self.columns,{Field:direct_assoc.with})[0];
					
					if(direct_assoc.with != null)
					{
						cont = true;
					}
					else
					{
						cont = false;	
					}
			
				}
			}			

		}
		else
		{
			//console.log("no exec");
			
		}
	}	

	function extra_column_getmodel (field)
	{
		var with_column = $filter('filter')(self.columns,{Field:field})[0];
		if(with_column.Key != "extra_column")
		{
			var with_model = $scope[with_column.key_data.REFERENCED_TABLE_NAME.capitalize()];
		}
		else
		{
			var get_from_indirect = extra_column_getmodel(with_column.with);
			var with_model = get_from_indirect.by_model;
		}	

		return {by_model:with_model};
	}

	$scope.extra_column = function(columns,column,row)
	{
		//console.log(column);
		
		var with_column = $filter('filter')(columns,{Field:column.with})[0];

		//console.log(with_column);
	
		if(with_column.Key != "extra_column")
		{
			var with_model = $scope[with_column.key_data.REFERENCED_TABLE_NAME.capitalize()];

			//Por medio del Key data accedo a la tabla de referencia esta a su vez me permite instanciar el modelo inmediato del
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

	$scope.get_column_by_reference = function(header,model=false){
		if(model)
		{
			model = $scope[model];

			var column = $filter('filter')(model.columns,{Field:header.Field})[0];
			
			if(column == null)
			{
				var column = $filter('filter')(model.headers,{Field:header.Field})[0];
				// Si no esta en las columnas de la base de datos, entonces va a estar en los headers ya que estas columnas fuerón posteriormente creadas como objetos json		
			}		

			return column;	
		}
		else
		{
			var column = $filter('filter')(self.columns,{Field:header.Field})[0];
			
			if(column == null)
			{
				var column = $filter('filter')(self.headers,{Field:header.Field})[0];
				// Si no esta en las columnas de la base de datos, entonces va a estar en los headers ya que estas columnas fuerón posteriormente creadas como objetos json		
			}		

			return column;	
		}
		
		
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

	$scope.foreign_value = function(key_data,f_id,return_value = false){
		//console.log(key_data);
		
			var filter_object = {};
			filter_object[key_data.REFERENCED_COLUMN_NAME] = f_id;
			//creo un objeto que tenga la columna de referencia

			var foreign_data = $filter('filter')($scope[key_data.REFERENCED_TABLE_NAME.capitalize()].rows,filter_object)[0];
			//Después busco el objeto y le regreso su valor por defecto	
			if(!return_value)
			{
				if(foreign_data != null)
				{
					return foreign_data[$scope[key_data.REFERENCED_TABLE_NAME.capitalize()].default];
					//La razón de este codigo es para capturar el valor por defecto de forma dinámica	
				}
				else
				{
					return "";
				}		
			}
			else
			{			
				// El return value es un valor explicito
				return 	foreign_data[return_value];
			}		
	}

	$scope.reload_ngtable = function(ngtable)
	{
		self[ngtable].reload();
	}


	$scope.execute_action = function(row,model,action)
	{
		//console.log(action);
		   switch (action.action) {
			 	case "get_evals":
			 		get_evaluations(row);
			 		break;
			 	case "get_comments":
			 		get_comments(row);
			 		break;
			 	case "download_comment_file":
			 		var exec = function(){
			 			$window.location.assign(global_url+"/matriz/archivo_comentario/"+row.id);				 		
			 		}
			 		exec();
			 		break;
			 	case "create_comment":
			 		create_comment(row);
			 		break;
			 	case "delete":
			 		var exec = function(){

			 		}
			 		exec();
			 		break;		
			    default:
			    	alert("Acción no definida");
			    	break;
			}
	}

	

	$scope.new_comment = {};

	function create_comment(row)
	{
		$("#AbstractSecondModal").modal("show");
		$scope.secondmodal = {title:"Crear Comentario",size:"modal-md",content:"new_comment_form",model:"Comentarios"};
		$scope.new_comment.requisito = row.id_Requisitos;				
	}

	$scope.save_comment = function()
	{
		//console.log($scope.new_comment);
		if($scope.new_comment.titulo == "" || $scope.new_comment.comentario == "")
		{
			return alert("Faltan datos para relizar este proceso");
		}
		else
		{
		    var fileFormData = new FormData();
            if($scope.new_comment.archivo != null)
            {
            	fileFormData.append('archivo', $scope.new_comment.archivo);	
            }
            
            fileFormData.append('titulo', $scope.new_comment.titulo);
            fileFormData.append('comentario', $scope.new_comment.comentario);
            fileFormData.append('requisito', $scope.new_comment.requisito);

            uploadUrl = global_url+"/matriz/registercomment";

 			$http.post(uploadUrl, fileFormData, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined}
 
            }).then(function (response) {
            	alert("Comentario guardado");
 			
            }).catch(function (err) {
                alert("Error Mandando el correo electronico");
            });
		}	
		$scope.new_comment = {};
	}

	function get_comments(row)
	{
		$scope.Comentarios = new table('comentario',CrudServices,null,false,{id_Requisitos:row["id_Requisitos"]});
		$scope.Comentarios.ready.then(function(){
			$("#AbstractSecondModal").modal("show");



			var buttons = [{title:'Descargar',action:'download_comment_file',icon:'download',role:[1,2,3],condition:{type:"notnull",column:"archivo"}}];
			$scope.Comentarios.columns.push({"Field":"Opciones","title":"Opciones","actions":buttons});
			$scope.Comentarios.headers = [
				{Field:"id",title:"id",filter:{id:"number"}},
				{Field:"titulo",title:"titulo",filter:{comentario:"text"}},
				{Field:"comentario",title:"Comentario",filter:{comentario:"text"}},
				{Field:"Opciones",title:"Opciones"},
			];

			$scope.$apply(() => {
				var modalT = {};
				modalT.headers = $scope.Comentarios.headers;
				$scope.secondmodal = {title:"Comentarios",size:"modal-md",content:"table_in_modal_with_headers",TableModal:modalT,model:"Comentarios"};
				$scope.ModalSecondNgtable = new NgTableParams({},{ dataset: $scope.Comentarios.rows});
				$scope.ModalSecondNgtable.reload();
			});
		});
	}

	function get_evaluations(row)
	{
		//console.log(row);
		$scope.Evaluaciones = new table('evaluacion',CrudServices,null,false,{id_Requisitos:row["id"]});
		$scope.Evaluaciones.ready.then(function(){			
			$scope.Evaluaciones.headers = [
			   {Field:"id",title:"id",filter:{id:"number"}},
			   {Field:"fecha",title:"fecha",filter:{fecha:"text"}},
			   {Field:"cumplimiento",title:"Estado de cumplimiento",filter:{cumplimiento:"text"}},
			   {Field:"fecha_prox",title:"Próxima fecha de evaluación",filter:{fecha_prox:"text"}},
			   {Field:"Opciones",title:"Opciones"}
			];
			console.log($scope.Evaluaciones);			
			$scope.$apply(() => {
				var modal_headers = $scope.Evaluaciones.headers;
				
				
				
				if($scope.Evaluaciones.rows.length > 1)
				{

					var after_action = function(){
						console.info("Exec");
						
						$scope.modal.only_last_row = false;
						
					};
					var table_modal_properties = {headers:modal_headers,action:"show_all",callback:after_action,buttonname:"Mostrar Evaluaciones anteriores"};
				}
				else
				{
					var table_modal_properties = {headers:modal_headers};
				}
				

				var buttons = [{title:'Crear comentario',action:'create_comment',icon:'comment',role:[1,2,3],condition:{type:"last"}},{title:'Ver comentarios',action:'get_comments',icon:'list',role:[1,2,3],condition:{type:"last"}}];

				$scope.Evaluaciones.columns.push({"Field":"Opciones","title":"Opciones","actions":buttons});

				//console.info($scope.Evaluaciones);

				var om =  new open_modal({title:"Evaluaciones",size:"modal-lg",content:"table_in_modal_with_headers",TableModal:table_modal_properties});
				om.execute();
				$scope.modal = om.output();
				//console.log($scope.modal);
				$scope.modal.model = "Evaluaciones";
				$scope.modal.only_last_row = true;
				if($scope.modal)
				{				
					self.ModalNgtable = new NgTableParams({},{ dataset: $scope.Evaluaciones.rows});
					self.ModalNgtable.reload();
				}

			});
		});

		
	}	


	$scope.simple_modal_action = function(action,callback)	
	{

		callback();
	}

	$scope.view_last_condition = function(last,row,validation)
	{
		if(validation)
		{
			if(last)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return true;
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

	$scope.evaluate_column_conditions = function(condition,row,model = null)
	{
		//console.log(row);
		if(condition == null)
		{
			return true;
		}
		else
		{			
			switch(condition.type){
				case "equal":
					if(row[condition.column] == condition.value)
					{
						return true;		
					}
					else
					{
						return false;
					}
					break;
				case "last":
				    //console.log(model);
					//console.log($scope[model].rows[$scope[model].rows.length -1]);
					if($scope[model].rows[$scope[model].rows.length -1] == row)
					{
						return true;
					}
				break;
				case "notnull":
				    //console.log(model);
					//console.log($scope[model].rows[$scope[model].rows.length -1]);
					if(row[condition.column] != null && row[condition.column] != "")
					{
						return true;
					}
				break;		
				default:
				break;
			}

			return false;

			
		}
	}

	table.prototype.control = function(buttons){
		var extra_column = {"Field":"Opciones","title":"Opciones","actions":buttons};
		this.columns.push(extra_column);
	}
	

	$scope.isWatching = function()
	{
		//console.log("is watching");
		return true;
	}

	$scope.render_edit = function(data)
	{
		//console.log("here");
		if($scope.session_roles(data.roles))
		{
			return true;
		}
	}



	$scope.save_property_to_db = function(data_to_save,field,related_id,Key)
	{
		

		var data_to_request = {data_to_save:data_to_save,field:field,related_id:related_id};

		if($filter('filter')(request_alredy_done,data_to_request)[0] == null && data_to_save.length > 0)
		{			
			request_alredy_done.push(data_to_request);		

			
			$(".loading").show();

			if(Key == 'json_columns')
			{ 
				var request = SystemServices.save_property_to_db({field:field,data_to_save:data_to_save,related_table:"Requisitos",related_id:related_id,description:"Columna Extra Schlumb"});
			}
			else			
			{
				console.log(self.tableModel);
				console.log(Key);
				$(".loading").hide();
				return false;
			}

			request.then(function(response){
				
				$(".loading").hide();

				if(response.data.status!=null)
				{
					//alert("Datos guardados");
				}
				else
				{
					alert("Sucedio un error guardando los datos");
				}
			});	
			
		}		
	}

	$scope.get_from_json_data = function(related_table,field,related_id)
	{
		var data_filter = {related_table:related_table,related_id:related_id};
		row = $filter('filter')($scope.Extra_json_data.rows,data_filter)[0];
		//console.log(row);
		if(row != null)
		{
			var json_data = JSON.parse(row.json_data);
			//console.log(json_data);
			//console.log(field);
			return json_data[field];
		}
		else
		{
			return "";
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

	$scope.add_to_selected_boxes = function(id)
	{
		console.info(id);

		if($scope.selected_boxes.indexOf(id) != -1 )
		{
			console.log($scope.selected_boxes.indexOf(id));			
			$scope.selected_boxes.splice($scope.selected_boxes.indexOf(id), 1);
			return true;		
		}

		if($scope.enterprise_selected == "")
		{	
			event.preventDefault();
			return alert("Seleccione primero una empresa para realizar esta evaluación en el filtro");
		}
		else
		{
			console.log("here");
			$scope.selected_boxes.forEach(function(element){
				var row = $filter('filter')($scope.Requisitos.rows,function(value){
        			return value.id === element;
				})[0];

				//console.log(row);
				//console.log($scope.enterprise_selected);
				if(row.id_empresa != $scope.enterprise_selected)
				{
					return alert("No puede combinar requisitos de distintas empresas para evaluar");
				}
				
			});
			
			$scope.selected_boxes.push(id);
		}
		
	}

	$scope.evaluate_reqs = function()
	{
		//console.log("clicked");
		if($scope.selected_boxes.length > 0)
		{
			console.log($scope.selected_boxes);
			$scope.secondmodal = {};
			$scope.secondmodal.content = 'evaluation_form';
			$("#AbstractSecondModal").modal("show");

			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();

			if(mm < 12)
			{
				mm = "0"+mm;
			}

			if(dd < 10)
			{
				dd = "0"+dd;
			}

			$scope.today = yyyy+"-"+mm+"-"+dd;

			console.log($scope.today);

			
			
			//document.getElementById('fechaini').setAttribute("min", yyyy+"-"+mm+"-"+dd);
		
		}
		else{
			return alert("Seleccione primero algun requisito para evaluar");
		} 
	}

	$scope.new_eval = {};

	$scope.save_eval = function()
	{

        var datetimeStart = document.getElementById('fechaini').value;  
        var datetimeEnd = document.getElementById('fechaprox').value; 

        if(Date.parse(datetimeStart) >= Date.parse(datetimeEnd)){
           alert("El valor de la fecha de proxima evaluación no puede ser menor o igual al de fecha de evaluación");
           return false;
        }

        var evidenciacump = $("#evidenciacump").val();

		$scope.new_eval.fechaini = datetimeStart;
		$scope.new_eval.fechaprox = datetimeEnd;

		$scope.new_eval.reqs_to_eval = $scope.selected_boxes;

		$scope.new_eval.evidenciacump = evidenciacump;

		console.log($scope.new_eval);
        
        var fileFormData = new FormData();
            
            fileFormData.append('calificacion', $scope.new_eval.calificacion);
            fileFormData.append('fecha', $scope.new_eval.fechaini);
            fileFormData.append('fechaprox', $scope.new_eval.fechaprox);
            fileFormData.append('evidenciacump', $scope.new_eval.evidenciacump);
            
            var text_in_array = "";
            $scope.new_eval.reqs_to_eval.forEach(function(element){
            	text_in_array += element+",";
            });


            fileFormData.append('reqs_to_eval', text_in_array.substring(0, text_in_array.length - 1));
            
            uploadUrl = global_url+"/matriz/evaluate";

 			$http.post(uploadUrl, fileFormData, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined}
 
            }).then(function (response) {
            	alert("Evaluaciones realizadas");
            	UncheckAll();
            	$scope.selected_boxes = [];
            	$("#evidenciacump").val("");
            	$("#fechaini").val("");
            	$("#fechaprox").val("");
				$scope.new_eval = {};
				$("#AbstractSecondModal").modal("hide"); 			
            }).catch(function (err) {
                alert("Error");
            });
		
	}

	$scope.create_req = function()
	{
		$scope.create_register = true;
		window.scrollTo(0,document.body.scrollHeight);
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

function UncheckAll(){ 
      var w = document.getElementsByTagName('input'); 
      for(var i = 0; i < w.length; i++){ 
        if(w[i].type=='checkbox'){ 
          w[i].checked = false; 
        }
      }
  }