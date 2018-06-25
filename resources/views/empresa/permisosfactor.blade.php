
@extends('layouts.admin')
	@section('content')
<br>  

	<?php $message=Session::get('message')?>

@if($message == 'update')
<div class="alert alert-warning alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<strong>Factores asignados exitosamente</strong>  
</div>
@endif
@if($message == 'update2')
<div class="alert alert-warning alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<strong>Aspectos asignados exitosamente</strong>  
</div>
@endif
@if($message == 'invalid')
<div class="alert alert-warning alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<strong>Selección no valida</strong>  
</div>
@endif
<body onload="creFormas()">
<style type="text/css">
  #subrayado
   {
      text-decoration: none;
      font-family: Impact;
     
   }  
  #subrayado:hover
   {
      text-decoration: none;
      
     
   }  

   
</style>
{{Html::script('js/GetChecked.js')}}
<div class="box box-primary" style="max-width:500px !important;">
  <div class="box-header with-border">
    <h3 class="box-title">Asignación Factores/Aspecto</h3>
  </div>
    <div class="load" style= "max-height:0px">
  </div>
    @if(isset($intg2))
      <form id='form1' action='insertaspecto' method='post' enctype='multipart/form-data'>
    	@else
      <form id='form1' action='insertfactor' method='post' enctype='multipart/form-data'>
      @endif
    			<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

    			<div class="form-group" >
    				{!!Form::label('Empresa')!!}
    				{!!Form::select('empresa',$empresas,null,['id'=>'empresa','class'=>'form-control ','placeholder'=>'Seleccione Empresa','required'])!!}
    			</div>
          

    			<div id="thform">formulario</div>

         <button type='submit' id='boton' class='btn btn-primary'>Registrar</button>
    	 </form>
</div>                   

     </body>
				 <script>
              function creFormas(){
                var totalFactores = Math.floor('<?php echo $totalFactores ?>');
                
                //console.log("variable "+totalFactores);
                var f="";
                       
                for(var i=1;i<totalFactores+1;i++){ 
                var Factores = <?php echo json_encode($Factores); ?>;                
                f+="<input type='checkbox' class='checks' name='factor"+i+"'  value='"+i.toString()+"' id='"+i+"''>"
                f+="<label class='labels'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"+Factores[i]+"</label>"   
                f+="<br>"
                //console.log(Factores[i]);                        
                } 
              document.getElementById("thform").innerHTML=f;
            }

            var way = ('<?php echo $switch ?>');
         </script>

  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed"> 
        @if(isset($intg2))
       <span id=subrayado> Descripción de aspectos asociados </span>
       @else
      <span id=subrayado> Descripción de factores asociados </span>
      @endif
        </a>
      </h4>
    </div>
   <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">  
    <div class="panel-body">   
      <section class="content-header">
   @if(isset($intg2))    
  <h4> <i class="fa fa-list-ul"></i> Descripción de aspectos asociados</h4>
  @else
    <h4> <i class="fa fa-list-ul"></i> Descripción de factores asociados</h4>
  @endif
  <ol class="breadcrumb">
  <div class="table-responsive ocultar_400px">
    <table class ="table">
        <thead>
          <th>Empresa </th>
          @if(isset($intg2))
          <th>Aspectos Ambientales asociados</th>
          @else 
          <th>Factores de Riesgo asociados</th>
          @endif
       </thead>
       @foreach($ents as $ent)
       <tbody>
          <td>
            {{$ent->nombre}}
          </td>
          <?php
          if(isset($intg2))
          {
           if($ent->aspectos=="Ninguno")
            { 
              echo'<td>'.$ent->aspectos.'</td>';
            }
            else
            {
              $arreglo = explode(",",$ent->aspectos);
              //echo'<td>'.var_dump($arreglo).'</td>';
              echo'<td>';
              for($i=0;$i<count($arreglo);$i++)
              {
                echo " ".Sig\Helpers\Exception_manager::arrayExcept($Factores,$arreglo[$i])." ,";
              }
              echo'</td>';              
            }
          } 
          else
          {  
            if($ent->factores=="Ninguno")
            { 
              echo'<td>'.$ent->factores.'</td>';
            }
            else
            {
              $arreglo = explode(",",$ent->factores);
              //echo'<td>'.var_dump($arreglo).'</td>';
              echo'<td>';
              for($i=0;$i<count($arreglo);$i++)
              {
                echo " ".Sig\Helpers\Exception_manager::arrayExcept($Factores,$arreglo[$i])." ,";
              }
              echo'</td>';
            }
          }

          ?>


      </tbody>
      @endforeach
    </table> 
    </div>
    </ol>
    </section>
     </div>
    </div>
  </div> 
		
	@stop

