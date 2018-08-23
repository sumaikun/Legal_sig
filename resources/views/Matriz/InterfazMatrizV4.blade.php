@extends('layouts.layout2')

  @section('content')

    <br>
    <div class="container">
    	
    	{!!Html::style('css/resize_table_with_columns.css')!!}

		<div class="row">
		  <div class ="col-lg-12">
		    <h2>Matriz - Requisitos Legales</h2>
		    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
		      <div ng-app="Appi">
		        <div id="matrizscope" ng-controller="MatrizController as MC">		        
		        	<div ng-include src="'{{ url('/') }}/js/Views/Normal_table.html'"></div> 
		        </div>
		      </div>
		    </div>
		  </div>
		</div>        	

    </div>




@stop 