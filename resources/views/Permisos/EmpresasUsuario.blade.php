@extends('layouts.admin')
 @section('content')

 
<?php $message=Session::get('message')?>

@if($message == 'update')
<br>
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Usuario Actualizado exitosamente</strong>  
</div>
@endif

    <br>
    <section class="content-header">
    <h4> <i class="fa fa-list-ul"></i> Asignar Permisos </h4>
    <ol class="breadcrumb">
    <div class="table-responsive ocultar_400px">
    {{Html::style('css/permisos.css')}}   
          
       <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th class ="thead"> Nombre  </th>
            <th class ="thead"> Usuario  </th>    
            <th class ="thead">estado </th>
            <th class ="thead2">rol </th>
            <th class ="thead3"></th>
          </tr>
         </thead>          
         <tbody >
         @foreach($users as $user)
          <tr>
            <td class ="tbody" id="busca_info"> {{$user->nombre}}   </a></td>
            <td> {{$user->usuario}}  </td>        
            <?php
            $tipoestado;
            switch ($user->estado)
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
            echo '<td>'.$tipoestado.'</td>';
            ?>              
            <?php
            $tipoRol = $user->rol_id ;

            echo '<td>'.$roles[$tipoRol].'</td>';
            ?>

            <td>
              <button type="button" class="btn btn-warning find" data-toggle="modal" onclick="permission_assigned({{$user->idusuario}})" data-target="#myModal"> Asignar</button>  
            </td>
         </tr>     
         @endforeach
         </tbody>               
      </table>
    </div>
  </ol>
  </section>

  <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form action="AgregaPer" method="get">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Asignar permisos</h4>
      </div>
      <div class="modal-body">
        
          <input type="hidden" id="idusuario" name="idusuario"/>
          <div id="thform"></div>         
        
      </div>
      <div class="modal-footer">
         <button type="submit" class="btn btn-success">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>
  </div>
</div>

   <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
   <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

            

<script>
  $(document).ready(function() {
    
    $('#example').DataTable({
       "bSort": false,
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
        }
    });
  });

  var init = creFormas();

  function creFormas(){
      var totalEmpresas = Math.floor('<?php echo $totalEmpresas ?>');
      
      console.log("variable "+totalEmpresas);
      var f="";
             
      for(var i=1;i<totalEmpresas+1;i++){ 
      var Empresa = <?php echo json_encode($Empresas); ?>;                        
      f+="<label class='labels'>"+Empresa[i]+"</label>"   
      f+="<input type='checkbox' name='empresa"+i+"' class='checks' value='"+i.toString()+"' id='"+i+"'>"
      }
 
      document.getElementById("thform").innerHTML=f;
  }

  function permission_assigned(id)
  {
    $("#idusuario").val(id);
    $.get('mPermisos/'+id, function(res){
          $(".checks").prop('checked', false);      
          var array = res.split(",");
          array.forEach(function(entry){
            $('input[name="empresa'+entry+'"]').prop('checked', true);
        });
      });
  }
</script>


             







@stop   