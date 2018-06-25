
@extends('layouts.admin')
	
<?php $message=Session::get('message')?>

@if($message == 'store')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Norma derogada creada exitosamente</strong>  
</div>
@endif
@if($message == 'update')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Norma derogada  Actualizado exitosamente</strong>  
</div>
@endif


	@section('content')

  	<section class="content-header">
	<h4> <i class="fa fa-list-ul"></i> Descripción de normatividad Derogada</h4>
	<ol class="breadcrumb">
	<div class="table-responsive ocultar_400px">
     <table class ="table">

     		<thead>
     	
     		
             <th>Tipo de Norma </th> 
             <th>Numero</th>
             <th>Autoridad Emisora</th> 
             <th>Año de emisión</th>
             <th>Comentario</th> 
             <th>Fecha de derogación</th>
              <th>Usuario</th> 
           
     		 </thead>

     		 @foreach($der as $der)

     		 <tbody>
         <?php
        
         echo'<td>'.$tipo[$der->tipo_norma_id].'</td>';
         echo'<td>'.$norma[$der->norma_id].'</td>';
        
         ?>
        <td> {{$der->autoridad}}</td>
        <td> {{$der->year}}</td>
        <td> {{$der->comentario}}</td>
        <td> {{$der->fecha}}</td>
        <?php 
        echo'<td>'.$usuario[$der->usuario_id].'</td>';
        ?>
         
     		 	    		 	        	

     		 	<td>
     		 	{!!link_to_route('Derogada.edit', $title = 'Editar',$parameters = $der->idderogada,$attributes =['class'=>'btn btn-warning'])!!}
     		 	</td>
     	        <!--<td>
                  <button type="button" class="btn btn-warning">Editar</button>  
                </td>-->
     		 </tbody>
     		 @endforeach
     	</table> 

@stop	