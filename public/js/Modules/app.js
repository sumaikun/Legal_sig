var app = angular.module("Appi",["ngTable","ui.bootstrap"]);

/*app.filter('trustedhtml', 
   function($sce) { 
      return $sce.trustAsHtml; 
   }
);*/


(function() {
  

  app.config(setConfigPhaseSettings);

  setConfigPhaseSettings.$inject = ["ngTableFilterConfigProvider"];

  function setConfigPhaseSettings(ngTableFilterConfigProvider) {
    var filterAliasUrls = {
      "dynamic-select": "dynamic-select.html",
      
    };
    ngTableFilterConfigProvider.setConfig({
      aliasUrls: filterAliasUrls
    });

    // optionally set a default url to resolve alias names that have not been explicitly registered
    // if you don't set one, then 'ng-table/filters/' will be used by default
    ngTableFilterConfigProvider.setConfig({
      defaultBaseUrl: "ng-table/filters/"
    });

  }
})();

function accessScope(node, func) {
    var scope = angular.element(document.querySelector(node)).scope();
    if(!scope.$$phase)
    {
    	scope.$apply(func);	
    }
    
}

function getfromScope(node,key)
{
	 var scope = angular.element(document.querySelector(node)).scope();
	 return scope[key];
}




app.factory('sessionInjector',[function() {  
    var sessionInjector = {
        request: function(config) {
        	//console.log(config);            
            config.headers['x-session-token'] = $('meta[name="csrf-token"]').attr('content');            
            return config;
        }
    };
    return sessionInjector;
}]);



app.config(['$httpProvider', function($httpProvider) {  
    $httpProvider.interceptors.push('sessionInjector');
}]);


function table(table,resource,table_headers,safe_index=false,get_by="All")
{
	var resulset = null;
	
	this.table = table;	

	if(window.localStorage.getItem(this.table) != null)
	{
		//console.log("save in memory");
		var item = JSON.parse(window.localStorage.getItem(this.table));
		//return item;
		//return window.localStorage.getItem(this.table);
	}
	
	this.resource = resource;
	
	this.table_headers = table_headers;
	
	this.safe_table = safe_index;

	//this.loaded = [];
	
	this.ready = this.init(get_by);
	
	this.test = function()
	{
		this.resource.test(this);
	}
	
	this.default = null;

	this.save_state();
	
}

table.prototype.init = function(get_by)
{
	//El get by es para poder filtrar la empresa por usuario
	
	var self = this;

		var asyncprocess = new Promise( (resolve, reject) => {

			if(get_by == "All")
			{ 		
				var request = self.resource.getAll(self);		
 			}
 			else
			{
				//console.log("get_by");
				var request = self.resource.getBy({get:get_by,table:self.table});	
			}

			request.then(function(response){
				 self.rows = response.data.rows;
				 var request2 = self.resource.getMETA_COLUMNS(self);
			
					//self.loaded.push(request2);
					var column_promises = [];		
				    
				    request2.then(function(response){

					 	self.columns = response.data.columns;
					 	self.columns.forEach(function(element,idx){			 					 	

				    	if(element.Type.includes("varchar") && self.default == null)
					  	{
					  		 self.default = element.Field;			  	
					  	}
					  	if(element.Key.includes("PRI"))
					  	{
					  		 self.primary_key = element.Field;			  	
					  	}
					  	if(element.Key.includes("MUL"))
					  	{
					  		
					  		var request3 = self.resource.foreign_data(element.Field,self.table);
					  		column_promises.push(request3);
					  		request3.then(function(response){			  			
					  			element.key_data = response.data.f_data[0];
					  		});
					  	}
					  });
					  if(column_promises.length > 0)
					  {
					  	 Promise.all(column_promises).then(values => {		  	   
							resolve("¡loaded!");	   			  
						  });
					  }
					  else
					  {
					  	resolve("¡loaded!");
					  }
			   });
			});			
		});
	//self.loaded.push(asyncprocess);

	return asyncprocess;

}


table.prototype.save_state = function()
{
	var self = this;
	self.ready.then(function(response){

		//window.localStorage.setItem(self.table,JSON.stringify(self));
	});
}


table.prototype.create = function(row,copy,frontable=false){
	$(".loading").show();
	
	var last = this.rows[this.rows.length - 1];
	//console.log(last);
	
	row.id = (parseInt(last.id)+parseInt(1)).toString();	
	
	copy = angular.copy(row);
	
	this.rows.push(copy);
	
	copy = {};
	
	this.data = row;

	if(frontable!=false)
	{
		frontable.reload();	
	}
	
	//console.log(this);

	//--- Cuando el número de lineas supera un limite no manda request al ser tan grande por eso debo eliminarlas

	object_without_rows = angular.copy(this);

	delete object_without_rows["rows"];

	var request = this.resource.create(object_without_rows);

	//------------------------------------------------------------------------------

	request.then(function(response){
		if(response.data.status == 1)
		{
			swal(
                  'Registro creado',
                  '',
                  'success'
            );
            $(".loading").hide();			
		}
		else
		{
			swal({
                  type: 'error',
                  title: '',
                  text: 'Error al guardar el registro'                 
            });
		}
		
	});
   
};

table.prototype.update = function(row){
   this.data = JSON.stringify(row, function (key, val) {
		 if (key == '$$hashKey') {
		   return undefined;
		 }
		 return val;
	});

	this.data = angular.fromJson(this.data);		
	var request = this.resource.persist(this);
	request.then(function(response){
		if(response.data.status == 1)
		{
			
			swal(
                  'Registro editado',
                  '',
                  'success'
            );

		}
		else
		{
			swal({
              type: 'error',
              title: 'Oops...',
              text: response.data.message,
              footer: '<a href>Why do I have this issue?</a>'
            });
				
		}
	});
};

table.prototype.delete = function(row,frontable=false)
{	
	if(confirm("¿Esta seguro de realizar este proceso?"))
	{
	 	$(".loading").show();
		this.data = angular.fromJson(row);	
		var request = this.resource.delete(this);
		var object = this;
		request.then(function(response){
			//console.log(object);
			
			if(response.data.status == 1)
			{
				var index = object.rows.indexOf(row);
				object.rows.splice(index, 1);				

				swal(
                  'Eliminado',
                  '',
                  'success'
	            );

	            $(".loading").hide();	

				if(frontable!=false)
				{
					frontable.reload();	
				}
				
			}
			if(response.data.status == 2)
			{
				alert(response.data.message);
			}
			
		});
	}		
};

		



function isEmpty(obj) {
	for(var key in obj) {
		if(obj.hasOwnProperty(key))
			return false;
	}
	return true;
}

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] === obj) {
            return true;
        }
    }
    return false;
}

var stop = {proccess:"STOP"};



function action()
{
	this.init = function()
	{
		for (var name in this) {
		  if(this[name] == null)
		  {
		  	alert("La propiedad con el nombre "+name+" no se encuentra en el objeto");
		  	return stop;
		  }
		}
	}

}

function vertex(actiona,actionb)
{

}

function node(vertex,edges)
{
	this.vertex = vertex;
	var total = edges.length;	      
}



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