@extends('layouts.admin')
@section('content')





    <section class="content-header">
    <br>    
    <h4> <i class="fa fa-list-ul"></i> Reporte ultima actualización </h4>
    <ol class="breadcrumb">
    <div class="table-responsive ocultar_400px">
     <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr class="table_head">
            <th> Empresa  </th>
            <th> Fecha ultima actualización</th>
                     
        </tr>  
      </thead>
      <tbody>   
         @foreach($data as $d)      
        <tr>
         	<td> {{$d['empresa']}}  </td>        
        	<td align="center"> {{$d['fecha']}} </td>        
        </tr>
        @endforeach
      </tbody> 
    </table> 
 </div>
 </ol>
 </section>





@stop