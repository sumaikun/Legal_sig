@extends('layouts.admin')

	

  @section('content')
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    {!!Html::style('css/bootstrap3-wysihtml5.min.css')!!}

	<br>
	Mailbox
	
	<div class="box">
    <div class="box-header">
      <h3 class="box-title">Plantilla de correo electronico <small>SIG</small></h3>
      <!-- tools box -->
      <div class="pull-right box-tools">
        <button class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
      </div><!-- /. tools -->
    </div><!-- /.box-header -->
    <div class="box-body pad">
      <!--<form method="post" action="/Correo/testmail">-->
      	<label>Para:</label>
      	<input id="receptor" type="email">
      	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
        <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
        <button onclick="get_html_email()" class="btn btn-success form-control">Enviar</button>
      <!--</form>-->
    </div>
  </div>

   <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    {{Html::script('js/bootstrap3-wysihtml5.all.min.js')}}    
    <script>
      $(function () {        
        $(".textarea").wysihtml5();
      });

      function get_html_email()
      {
          $.post( "testmail",{_token:'{{ csrf_token() }}',html:$('.wysihtml5-sandbox').contents().find('body').outerHTML(),
          receptor:$("#receptor").val()},function( data ){
            alert("Mensaje enviado");
          });
          //var html  = $('.wysihtml5-sandbox').contents().find('body').outerHTML();
          console.log(html);
      }      

      jQuery.fn.outerHTML = function() {
        return jQuery('<div />').append(this.eq(0).clone()).html();
      };
    </script>

@stop
