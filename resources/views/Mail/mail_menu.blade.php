@extends('layouts.admin')

<style>
	.overlay {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  height: 100%;
  width: 100%;
  opacity: 0;
  transition: .5s ease;
  background-color: rgba(255,255,255,0.6);
}

.content-image:hover .overlay {
  opacity: 1;
}

.text {
  color: black;
  font-size: 20px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}
</style>

  @section('content')

    <?php $message=Session::get('message')?>
	

    @if($message == 'deleted')
    <br>
    <br>
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Correo eliminado</strong>  
    </div>
    @endif

    @if($message == 'sended')
    <br>
    <br>
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Correo enviado</strong>  
    </div>
    @endif


    @if($message == 'assigned_permission')
    <br>
    <br>
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Permisos registrados</strong>  
    </div>
    @endif

	<div class="row" >

		<div class="container text-center" style="margin-top: 30px;">

			<div class="col-md-3 col-lg-3 " >
				<h3>Menu de permisos</h3>
				<br>
				<div class="content-image">
					<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/Consensus_icon.svg/399px-Consensus_icon.svg.png" class="img-thumbnail img-responsive" alt="Permisos">
					<div class="overlay">
				    <div class="text"><a style="text-decoration: none;" href="Correo/permisos">Asignar permisos</a></div>
			    </div>
			  </div>
			</div>
			<div class="col-md-3 col-lg-3">
				<h3>Enviar correos de alertas</h3>
				<div class="content-image">
					<img src="https://www.iconexperience.com/_img/o_collection_png/green_dark_grey/512x512/plain/clipboard_check_edit.png" class="img-thumbnail img-responsive" alt="Alertas">
					<div class="overlay">
				    <div class="text"><a style="text-decoration: none;" href="Correo/panel">Alertas de correo</a></div>
			    </div>
			  </div>
			</div>
			<div class="col-md-3 col-lg-3">
				<h3>Buzon de correo</h3>
				<br>
				<div class="content-image">
					<img src="https://cdn0.iconfinder.com/data/icons/flaturici-set-5/512/mailbox-512.png" class="img-thumbnail img-responsive" alt="Alertas">
					<div class="overlay">
				    <div class="text"><a href="Correo/mipanel" style="text-decoration: none;">Correo</a></div>
			    </div>
			  </div>
			</div>
			

		</div>
	</div>


@stop