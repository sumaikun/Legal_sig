@extends('layouts.admin')
<?php $message=Session::get('message')?>
@if($message == 'noAllowed')
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>No esta autorizado</strong>  
</div>
@endif
  @section('content')
  <style>
    #level
    {
      margin-top: 3em;
    }
    .img-logo
    {
      width:120%; 
      height:120%;
    }
  </style>
    <section class="content-header">
  <h4>
  <i class="spinner"></i> 
  <tr>
      <br>
      <td><strong>BIENVENIDOS</strong></td>    
      <td> </td>
  </tr> <br>  
 <html><head> 
  <meta charset="utf-8">

  <link href="http://fonts.googleapis.com/css?family=Anton" rel="stylesheet" type="text/css">
  {!!Html::style('css/Animacionengranajes.css')!!}
</head> 
<body>
  <div id="level">
    <div id="content">
      <div id="gears">
        <div id="gears-static"></div>
        <div id="gear-system-1">
          <div class="shadow" id="shadow15"></div>
          <div id="gear15"></div>
          <div class="shadow" id="shadow14"></div>
          <div id="gear14"></div>
          <div class="shadow" id="shadow13"></div>
          <div id="gear13"></div>
        </div>
        <div id="gear-system-2">
          <div class="shadow" id="shadow10"></div>
          <div id="gear10"></div>
          <div class="shadow" id="shadow3"></div>
          <div id="gear3"></div>
        </div>
        <div id="gear-system-3">
          <div class="shadow" id="shadow9"></div>
          <div id="gear9"></div>
          <div class="shadow" id="shadow7"></div>
          <div id="gear7"></div>
        </div>
        <div id="gear-system-4">
          <div class="shadow" id="shadow6"></div>
          <div id="gear6"></div>
          <div id="gear4"></div>
        </div>
        <div id="gear-system-5">
          <div class="shadow" id="shadow12"></div>
          <div id="gear12"></div>
          <div class="shadow" id="shadow11"></div>
          <div id="gear11"></div>
          <div class="shadow" id="shadow8"></div>
          <div id="gear8"></div>
        </div>
        <div class="shadow" id="shadow1"></div>
        <div id="gear1"></div>
        <div id="gear-system-6">
          <div class="shadow" id="shadow5"></div>
          <div id="gear5"></div>
          <div id="gear2"></div>
        </div>
        <div class="shadow" id="shadowweight"></div>
        <div id="chain-circle"></div>
        <div id="chain"></div>
        <div id="weight"></div>
      </div>
    </div>
  </div>

</body></html>

  </section>

<aside>
 
  <?php
   echo Sig\Helpers\Externclass::logos();
  ?> 


</aside>

  @endsection