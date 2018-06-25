@extends('layouts.admin')
	
<?php $message=Session::get('message')?>

@if($message == 'store1')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Sector creado exitosamente</strong>  
</div>
@endif
@if($message == 'store2')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Industria creada exitosamente</strong>  
</div>
@endif
@if($message == 'update')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Dato Actualizado</strong>  
</div>
@endif
@if($message == 'deny')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>El dato ya existe</strong>  
</div>
@endif
@if($message == 'deleted')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Dato borrado</strong>  
</div>
@endif


	@section('content')
  <style type="text/css">
    #misFormas
    {
    visibility:hidden; 
    z-index:2;
    background-color:#AED6F1; 
    width:40%;
    border:solid #5DADE2 2px; 
    padding:3.5%;
     
    margin-top:-300%; 


    }
    .table{

     z-index:1;  
    }
            .titulo
         {
            text-align: center;
            border:2px solid #3300FF;
            background-color: #3366CC;
            font-family: Verdana;
            font-weight: bold;

         }

  
 a:hover {
    text-decoration: none;
   }  

 #btn-sectores {
   max-width: 100px; 
   display: inline-block;

 }

 #btn-industrias {
   max-width: 100px; 
   display: inline;
 }  


  </style>
    
    {{Html::script('js/GetSectoresIndustriasforms.js')}}
  
    @include('matriz.forms.modal')
    <br>
    <td><a href="#"><button class="btn btn-block btn-primary " id="addS" data-target='#myModal' data-toggle='modal'>Agregar Sector</button></a></td>  
    <td><a href="#"><button class="btn btn-block btn-success " id="addI" data-target='#myModal' data-toggle='modal'>Agregar Industria</button></a></td>
     <br> 
     <section class="content-header">
      <h4> <i class="fa fa-list-ul"></i> Lista de Industrias</h4>
    {{Html::script('js/GetTablasectores.js')}}
    {{Html::script('js/GetTablaindus.js')}}  
      <a href="#"><button class="btn btn-block btn-success " id="btn-industrias" >Industrias</button></a>
      <a href="#"><button class="btn btn-block btn-warning " id="btn-sectores" >Sectores</button></a>
      <ol class="breadcrumb">
      <div class="table-responsive content_table">
         <table class ="table" id="tb-industrias">
            <thead>
              <tr class="table_head">
                <th> Industria</th>
                <th> Sector</th> 
                <th> </th>
                <th> </th>          
              </tr>  
             </thead>
  
             <tbody>
             
             @foreach($industrias as $industria)
             <tr>         
                <td>{{$industria->industria}}</td>
                <td>{{Sig\Helpers\Exception_manager::arrayExcept($sectores,$industria->sector_id)}} </td>            
                <td>                  
                  <button type="button" class="btn btn-warning Iedit"  onclick="object.setid({{$industria->idindustria}})" data-target='#myModal' data-toggle='modal'>Editar</button>                  
               </td>
                <td>
                  <a href="deleteIndustria/{{$industria->idindustria}}">
                  <button type="button" class="btn btn-danger ">Borrar</button>
                  </a>
                </td>                 
             </tr>           
             @endforeach
            {{$industrias->render()}}     
           </tbody> 
        </table> 
     
       </div>
      </ol>
     </section>   



    
    
    
@stop	