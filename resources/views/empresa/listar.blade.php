
@extends('layouts.admin')
  
<?php $message=Session::get('message')?>

@if($message == 'store')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Empresa creada exitosamente</strong>  
</div>
@endif
@if($message == 'update')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Empresa Actualizada exitosamente</strong>  
</div>
@endif


  @section('content')
  <style>
  .table {
    font-size: 80%;
  }

  </style>
  <br>
  <section class="content-header">
  <h4> <i class="fa fa-list-ul"></i> Lista de empresas </h4>
  <ol class="breadcrumb">
  <div class="table-responsive ocultar_400px">
  <table class ="table">
        <thead>
          <tr class="table_head">       
            <th> Nombre</th>
            <th> Respresentante</th>
            <th> Cargo del Respresentante</th>
            <th> Fecha de Ingreso</th>
            <th> Comentario</th>
            <th> Sector</th>
            <th> Industria</th>
            <th> Estado </th>
            <th>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;Logo </th>
                <th> </th>
               <!-- <th> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Logo</th> -->
           </tr>    
         </thead>
          <tbody>
         @foreach($ents as $ents)
        
         <tr>
          <td style="text-align:center !important"> {{$ents->nombre}}</td>
          <td> {{$ents->representante_legal}}</td>
          <td> {{$ents->cargo}}</td>
          <td> {{ Carbon\Carbon::parse($ents ->created_at)->format('d/m/Y')}}  </td>
          <td> {{$ents->comentario}}</td>
          <?php
          echo'<td>'.Sig\Helpers\Exception_manager::arrayExcept($sector,$ents->sector_id).'</td>';
          echo'<td>'.Sig\Helpers\Exception_manager::arrayExcept($industria,$ents->industria_id).'</td>';
          
          ?>
          <?php
                $tipoestado;
                switch ($ents->estado)
                {
                    case 1: 
                        $tipoestado = "Activo";
                    break;
                    case 2:
                        $tipoestado = "Inactivo";
                    break;
                    case 3:
                        $tipoestado = "En mora";
                    break;
                   default:
                          $tipoestado = "Activo";
                         ;

                }

               echo '<td width="100px">'." ".$tipoestado.'</td>';
               
              ?> 
            <td > <img src="{{url('logos/'.$ents->path)}}"  class="img-responsive">  </td>               
          

              <td>
              {!!link_to_route('Empresa.edit', $title = 'Editar' , $parameters = $ents->idempresa, $attributes = ['class'=> 'btn btn-warning'])!!}
              </td>
              <!--<td>
                  <button type="button" class="btn btn-warning">Editar</button>  
                </td>-->
         
          </tr>
         @endforeach
          </tbody>
      </table> 


@stop 