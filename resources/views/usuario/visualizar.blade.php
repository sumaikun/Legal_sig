@extends('layouts.admin')
    
<?php $message=Session::get('message')?>

@if($message == 'store')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Usuario creado exitosamente</strong>  
</div>
@endif
@if($message == 'update')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Usuario Actualizado exitosamente</strong>  
</div>
@endif
@if($message == 'deleted')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Usuario Borrado</strong>  
</div>
@endif

@if($message =='error_correos')
  <div class="alert alert-warning alert-dismissible" role="alert">
   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Ya existe un correo igual en la base de datos</strong>  
  </div>
@endif

  @if($message =='invalid')
  <div class="alert alert-warning alert-dismissible" role="alert">
   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Ingreso inadecuado de datos</strong>  
  </div>
@endif    

@if(count($errors)>0)
<div class="alert alert-danger alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
 <ul>
    @foreach($errors->all() as $error)
      <li>{!!$error!!}</li>
    @endforeach 
   </ul>
     </div>
 @endif 


    @section('content')
    <br>
    <section class="content-header">

    <h4> <i class="fa fa-list-ul"></i> Listado de usuarios </h4>
    <ol class="breadcrumb">
    <div class="table-responsive ocultar_400px">
     <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr class="table_head">
                <th> Nombre  </th>
                <th> Usuario  </th>
                <th> correo </th>
                <th>estado </th>
                <th>rol </th>
                <th></th>
                <th></th>
              </tr>  
             </thead>
             <tbody>
             @foreach($users as $user)
             <tr>
                <td> {{$user->nombre}}  </td>
                <td> {{$user->usuario}}  </td>
                <td> {{$user->correo}}  </td>
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
                <a href="{{route('Usuario.erase',$user->idusuario)}}"><button class="btn btn-danger">Borrar</button></a>
                </td>
                <td>
                  <button onclick="edit_user({{$user->idusuario}})" class="btn btn-warning">Editar</button>
                </td>
               </tr>
             @endforeach
            </tbody>
        </table>
        <button class="btn btn-primary" data-target="#myModal" data-toggle="modal">+<i class="fa fa-users fa-fw"></i> Nuevo usuario</button> 
      </div>
    </ol>
  </section>
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

  function edit_user(id)
  {    
     $.get("Usuario/user_info/"+id, function(res){
      $(".edit_id").val(id);
      $("#edit_nombre").val(res.nombre);
      $("#edit_usuario").val(res.usuario);
      $("#edit_correo").val(res.correo);
      $("#edit_rol").val(res.rol_id);
      if(res.estado==0)
      {
        res.estado = 1;
      }
      $("#edit_estado").val(res.estado);  
      $("#myModal2").modal('show');    
    });

  }

  function changue_psw()
  {
      $("#myModal3").modal('show');
  }
</script>

  <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    {!!Form::open(['route'=>'Usuario.store', 'method'=>'POST'])!!}
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Nuevo usuario</h4>
      </div>
      <div class="modal-body">

        <div class="form-group">
          {!!Form::label('Nombre')!!}
          {!!Form::text('nombre',null,['id'=>'nombre','class'=>'form-control','placeholder'=>'Ingresa el nombre del usuario','maxlength'=>'45','required','pattern'=>'^[A-Za-z ]+$','title'=>'No se permite ingresar numeros'])!!}
        </div>
        <div class="form-group">
          {!!Form::label('Usuario')!!}
          {!!Form::text('usuario',null,['id'=>'usuario','class'=>'form-control','placeholder'=>'Ingrese usuario','maxlength'=>'12','required','pattern'=>'^[A-Za-z]+$','title'=>'No se permiten espacios'])!!}
        </div>
        <div class="form-group">
          {!!Form::label('Contraseña')!!}       
          {!!Form::password('password',['id'=>'password','class'=>'form-control','placeholder'=>'Ingrese la contraseña','maxlength'=>'18','required'])!!}
        </div>
        <div class="form-group">
          {!!Form::label('Correo')!!}
          {!!Form::email('correo',null,['id'=>'correo','class'=>'form-control','placeholder'=>'Ingresa su correo electronico','required'])!!}
        </div>
        <div class="form-group">
          <!--{!!Form::label('Rol')!!}
          {!!Form::select('rol',['1' => 'Administrador', '2' => 'Consultor', '3' => 'Director', '4' => 'Usuario Empresa'],null,['id'=>'rol','class'=>'form-control'])!!}-->
                {!!Form::label('Rol')!!}
          {!!Form::select('rol',$roles,null,['id'=>'rol','class'=>'form-control','placeholder'=>'Selecciona','required'])!!}
        </div>
      </div>
      <div class="modal-footer">
         {!!Form::submit('Registrar',['class'=>'btn btn-primary'])!!}
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    {!!Form::close()!!}
  </div>
</div>


<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <form action="Userupdate" method="POST">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar usuario</h4>
      </div>
      <div class="modal-body">

        {{ csrf_field() }}

        <input class="edit_id" name="id" type="hidden">

        <div class="form-group">
            <label for="Nombre">Nombre</label>
            <input id="edit_nombre" class="form-control" placeholder="Ingresa el nombre del usuario" pattern="^[A-Za-z ]+$" title="No se permite ingresar numeros" required="required" name="nombre" type="text">
          </div>
          <div class="form-group">
            <label for="Usuario">Usuario</label>
            <input disabled="disabled" class="form-control" id="edit_usuario" required="required" name="usuario" type="text">
          </div>
          
          <div class="form-group">
            <label for="Correo">Correo</label>
            <input id="edit_correo" class="form-control" placeholder="Ingresa su correo electronico" required="required" name="correo" type="email">
          </div>
          <div class="form-group">
            <label for="Rol">Rol</label>
            <select id="edit_rol" class="form-control" required="required" name="rol"><option selected="selected" value="">Selecciona</option><option value="1">Administrador</option><option value="2">Consultor</option><option value="3">Cliente</option></select>
          </div>
          <div class="form-group">
            <label for="Estado">Estado</label>
            <select id="edit_estado" class="form-control" name="estado"><option value="1">Activo</option><option value="2">Inactivo</option><option value="3">Mora</option></select>
          </div>              
      </div>
      <div class="modal-footer">
         {!!Form::submit('Actualizar',['class'=>'btn btn-primary'])!!}
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>
    <button onclick="changue_psw()" class="btn btn-primary">Cambiar contraseña</button>
  </div>
</div>

<div id="myModal3" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <form action="/UserupdatePsw" method="POST">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cambiar contraseña</h4>
      </div>
      <div class="modal-body">

        {{ csrf_field() }}

        <input class="edit_id" name="id" type="hidden">
        {!!Form::label('Nueva contraseña')!!}
        <input type="password" name="password">
        
      <div class="modal-footer">
         {!!Form::submit('Actualizar',['class'=>'btn btn-primary'])!!}
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>
  </div>
</div>

@stop   

    