<!doctype html>
<html lang="en-US">
<head>
    {!!Html::style('css/bootstrap.min.css')!!}
    {!!Html::style('css/metisMenu.min.css')!!}
    {!!Html::style('css/sb-admin-2.css')!!}
    {!!Html::style('css/font-awesome.min.css')!!}

    
	<meta charset="utf-8">
	<link href="css/stylesPrin.css" rel="stylesheet" type="text/css" />
	<title>Sistema de requisitos legales</title>
 
 


</head>

<body>
    <div>
    <?php $message=Session::get('message')?>

    @if($message == 'store')
    <div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Datos incorrectos</strong>  
    </div>
    @endif
    @if($message == 'inactivo')
    <div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Usted se encuentra inactivo  , si tiene alguna inquietud o necesita alguna ayuda haga click <a href="#">aqui</a></strong>  
    </div>
    @endif
    @if($message == 'enMora')
    <div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <strong>Usted se encuentra en Mora  , si ya cancelo y aun no puede ingresar al sistema  haga click <a href="#">aqui</a></strong> 
    </div>
    @endif
    @if($message == 'suitable')
    <div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <strong>Ingreso de forma inadecuada al sistema , si tiene alguna inquietud o necesita alguna ayuda haga click <a href="#">aqui</a></strong> 
    </div>
    @endif


    </div>

    <div id="login-form">

        <h1>Iniciar Sesi&oacute;n</h1>

        <fieldset>
        {!!Form::open(['route'=>'Login.store','method'=>'POST'])!!}
           <!-- <form action="" method="get"> -->
            <div class="form-group">
                {!!Form::label('Usuario')!!}
                {!!Form::text('usuario',null,['id'=>'usuario','class'=>'form-control','placeholder'=>'Ingrese usuario','maxlength'=>'12','required','pattern'=>'^[A-Za-z]+$','title'=>'No se permiten espacios','autocomplete'=>'off'])!!}
            </div>
            <div class="form-group">
                {!!Form::label('Contraseña')!!}             
                {!!Form::password('contrasena',['id'=>'contrasena','class'=>'form-control','placeholder'=>'Ingrese la contraseña'])!!}
            </div>
            <input name="_token" type="hidden" value="{{ csrf_token() }}">

        {!!Form::submit('Iniciar Sesión',['class'=>'btn btn-primary'])!!}
        {!!Form::close()!!}
                <!--<input type="text" required value="Usuario" onBlur="if(this.value=='')this.value='Usuario'" onFocus="if(this.value=='Usuario')this.value='' ">

                <input type="password" required value="Contraseña" onBlur="if(this.value=='')this.value='Contraseña'" onFocus="if(this.value=='Contraseña')this.value='' "> 

                <input type="submit" value="Entrar">
            </form> -->
        </fieldset>

    </div> 

</body>
</html>