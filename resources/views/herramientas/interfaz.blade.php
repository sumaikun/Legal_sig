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
  /*.table>tbody>tr>td>p{
      max-width: 150px;
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
  }*/
  select.form-control{
    font-size: 11px !important;
    min-width: 100px !important;
  }



</style>

{!!Html::style('css/resize_table.css')!!}

<div class="row">
  <div class ="col-lg-12">
    <h2>Parámetros</h2>
    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
      <div ng-app="Appi">
        <div ng-controller="CrudController as CC">
          <!--
          <button ng-click="Test_callbacks()">Test</button>
          -->
          <select onchange="select_table()" id="table_selected">
            <!--<option value="" label="-- Selecciona tabla --" disabled selected="selected"></option>-->
            <option value="" disabled selected="selected">-- Selecciona tabla --</option>           
            <option value="factores">Factores</option>
            <option value="categorias">Categorias</option>
            <option value="normas">Normas</option>
            <option value="articulos">Articulos</option>
            <!--<option ng-value="Literales">Literales</option>-->
            <option value="tipo_norma">Tipos norma</option>
            <option value="autoridad_emisora">Autoridades emisora</option>
            <option value="emision">Emisión</option>
          </select>
          <div ng-include src="'{{ url('/') }}/js/Views/Modal.html'"></div> 
          <div id="crud_content" class="table-responsive">
             <div ng-include src="'{{ url('/') }}/js/Views/Crud_table.html'"></div>
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
