@extends('layouts.layout2')

  @section('content')
  	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <br>
    <div class="container-fluid">
    	
    	{!!Html::style('css/resize_table_with_columns.css')!!}
    	{!!Html::style('css/arrow_button.css')!!}

		<div class="row">
		  <div class ="col-lg-12">
		    <h2>Matriz - Requisitos Legales</h2>
		    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
		      <div ng-app="Appi">		      	 
		        <div id="matrizscope" ng-controller="MatrizController as MC">
		        	<div ng-if="Session != null">  
			        	 <button ng-if="check_session_action([1,2])" class="btn btn-primary form-button" data-toggle="modal" data-target="#myModal3" ng-click="create_req()" title="crear nuevo"><span class="glyphicon glyphicon-plus"></span> Nuevo requisito</button>
					     
					     <button ng-if="check_session_action([1,2])" class="btn btn-warning form-button btn_one_req" ng-click="evaluate_reqs()"  title="evaluar"><span class="glyphicon glyphicon-pencil"></span> Evaluar</button>

					    <!--<button ng-if="check_session_action([1,2,3])" class="btn btn-success form-button btn_one_req" data-toggle="modal" data-target="#modalexcel" title="Descargar Excel"><span class="glyphicon glyphicon-menu-down"></span> Excel </button>-->
		        	</div>
		        	<div ng-include src="'{{ url('/') }}/js/Views/Normal_table.html'"></div> 
		        	<div ng-include src="'{{ url('/') }}/js/Views/Modal.html'"></div>
		        	<div ng-include src="'{{ url('/') }}/js/Views/Modals/secondModal.html'"></div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>        	

    </div>




@stop 