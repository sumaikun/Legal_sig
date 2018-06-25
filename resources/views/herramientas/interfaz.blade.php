@extends('layouts.admin')


  @section('content')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<br>
<style>
  /*.table>tbody>tr>td{
      max-width: 150px;
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
  }*/
  .table>tbody>tr>td>p{
      max-width: 150px;
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
  }
  select.form-control{
    font-size: 11px !important;
    min-width: 100px !important;
  }
</style>

<div class="row">
  <div class ="col-lg-12">
    <h2>Parámetros</h2>
    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
      <div ng-app="Appi">
        <div ng-controller="CrudController as CC">
          <!--
          <button ng-click="Test_callbacks()">Test</button>
          -->
          <select ng-change="select_table()"  ng-model="table_selected">
            <option value="" label="-- Selecciona tabla --" disabled selected="selected"></option>           
            <option ng-value="factores_view">Factores</option>
            <option ng-value="categorias_view">Categorias</option>
            <option ng-value="normas_view">Normas</option>
            <option ng-value="articulos_view">Articulos</option>
            <!--<option ng-value="Literales">Literales</option>-->
            <option ng-value="tipo_norma_view">Tipos norma</option>
            <option ng-value="autoridad_emisora_view">Autoridades emisora</option>
            <option ng-value="emision_view">Emisión</option>
          </select>
          <div ng-include src="'/js/Views/Modal.html'"></div> 
          <div id="crud_content" class="table-responsive">
             <div ng-include src="'/js/Views/Crud_table.html'"></div>
          </div>
        </div>
      </div> 
    </div>    
  </div>  
</div>

<script>
  function big_text_edit(elem){
    $('td').each(function(){
      $(this).css("white-space","nowrap");
    });
    $('p').each(function(){
      $(this).css("white-space","nowrap");
    });
    var id = $(elem).css("white-space","normal");   
  }

</script>
@stop
