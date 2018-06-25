var app = angular.module("Appi",["ngTable","ui.bootstrap"]);

app.filter('trustedhtml', 
   function($sce) { 
      return $sce.trustAsHtml; 
   }
);

function table(table,resource,table_headers,safe_index=false)
{
	var resulset = null;
	
	this.table = table;	
	
	this.resource = resource;
	
	this.table_headers = table_headers;
	
	this.safe_table = safe_index;
	
	this.init();
	
	this.test = function()
	{
		this.resource.test(this);
	}
	
	this.default = null;
}

table.prototype.init = function()
{
	
	var self = this;

	self.row_promise = this.resource.getAll(this);
	self.row_promise.then(function(response){
		 self.rows = response.data.rows;
		 console.log(self);		 			
	});

	self.column_promise = this.resource.getMETA_COLUMNS(this);
	
	
    
    self.column_promise.then(function(response){
	 	self.columns = response.data.columns;
	 	self.columns.forEach(function(element) {	
    	if(element.Type.includes("varchar") && self.default == null)
	  	{
	  		 self.default = element.Field;			  	
	  	}
	  	if(element.Key.includes("PRI"))
	  	{
	  		 self.primary_key = element.Field;			  	
	  	}
	  });
   });		
}

table.prototype.create = function(row,copy,frontable=false){
	
	var last = this.rows[this.rows.length - 1];
	console.log(last);
	
	row.id = (parseInt(last.id)+parseInt(1)).toString();	
	
	copy = angular.copy(row);
	
	this.rows.push(copy);
	
	copy = {};
	
	this.data = row;

	if(frontable!=false)
	{
		frontable.reload();	
	}
	
	var request = this.resource.create(this);
	request.then(function(response){
		if(response.data.status == 1)
		{
			alert("creado");			
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
			alert("Editado");
		}
	});
};

table.prototype.delete = function(row,frontable=false)
{	
	if(confirm("¿Esta seguro de realizar este proceso?"))
	{ 	
		this.data = angular.fromJson(row);	
		var request = this.resource.delete(this);
		var object = this;
		request.then(function(response){
			//console.log(object);
			
			if(response.data.status == 1)
			{
				var index = object.rows.indexOf(row);
				object.rows.splice(index, 1);
				alert("eliminado");
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

