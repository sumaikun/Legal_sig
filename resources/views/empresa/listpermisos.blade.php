@extends('layouts.admin')
@section('content')

  	<section class="content-header">
	<h4> <i class="fa fa-list-ul"></i> Descripción de factores asociados</h4>
	<ol class="breadcrumb">
	<div class="table-responsive ocultar_400px">
    <table class ="table">
    <thead>
    <th>Empresa </th> 
    <th>Factores de Riesgo asociados</th>
    </thead>

     @foreach($ents as $ents)
     <tbody>
     <td> {{$ents->nombre}}</td>
     <?php
     echo'<td>'.$factor[$ents->factor].'</td>';
     ?>
     </tbody>
     @endforeach
   
    </table> 

@stop