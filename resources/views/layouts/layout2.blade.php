<!DOCTYPE html>

<html lang="en">

<head>

  <script>
  
    var global_url = "{{ url('/') }}";

    </script>

{{Html::script('js/jquery-1.8.3.js')}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    {!!Html::style('css/bootstrap.min.css')!!}
    {!!Html::style('css/loader.css')!!}
    {!!Html::style('css/metisMenu.min.css')!!}
    {!!Html::style('css/sb-admin-2.css')!!}
    {!!Html::style('css/font-awesome.min.css')!!}
    {!!Html::style('css/overlay.css')!!}
         {!!Html::script('js/jquery.min.js')!!}
      <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
      <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">


    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js" ></script>
    <script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.11.0.js"></script>
    <link rel="stylesheet"; href="https://unpkg.com/ng-table@2.0.2/bundles/ng-table.min.css">
    <script src="https://unpkg.com/ng-table@2.0.2/bundles/ng-table.min.js"></script>
    {{Html::script('js/Modules/app.js')}}
    {{Html::script('js/Directives/contenteditable.js')}}

    {{Html::script('js/Directives/timestampToDate.js')}}
    {{Html::script("js/Services/BrainServices.js")}}
    {{Html::script("js/Services/SystemServices.js")}}
    {{Html::script("js/Services/CrudServices.js")}}
    {{Html::script('js/Directives/loading.js')}}
    {{Html::script("js/Controllers/BrainController.js")}}    
    {{Html::script("js/Controllers/MatrizController.js")}}

      @yield('css')

      <style>
        #import-content{
          width:all;
          margin-top: -30px;

        }
        #lease {
          border-bottom: 1px solid  #989898;
        }
        #enlace:hover {
          color:#003399; 
        }
        .table_head{
        background-color: #031A38;
        font-weight: bold;  
        font-size: 13px;
        color : white;
        }
        footer
        {
          background-color: #d4c9c9;
        }

        #ft-text
        {
          float: right;
          margin-right: 30px;
          width:300px;
        }

      </style>

</head>

<body>

    <div class="popup loading" style="display: none;">
      <div>
        <p style="text-align:center">
          <img src="{{ url('/') }}/gif/LoadingAjax.gif"/>REQLEGAL...
        </p>
      </div>
    </div>

<div id=lease>
  <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0" >
            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" >
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                @if(Auth::user()->rol_id == 1)
                <a href="{{route('admin')}}" id="enlace" class="navbar-brand">Administrador</a>
                @endif
                 @if(Auth::user()->rol_id == 2)
                <a class="navbar-brand" href="{{route('admin')}}" id="enlace">Consultor</a>
                @endif
                 @if(Auth::user()->rol_id == 3)
                <a class="navbar-brand" href="{{route('admin')}}" id="enlace">Cliente</a>
                @endif
            </div>
        
      <ul class="nav navbar-top-links navbar-right">
                 <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                     {!!Auth::user()->nombre!!}<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <!--<li><a href="#"><i class="fa fa-gear fa-fw"></i> Ajustes</a>
                        </li>
                        <li class="divider"></li>
                         @if(Auth::user()->rol_id != 3)
                        <li><a href="/evaluations"><i class="fa fa-gear fa-fw"></i>Mis evaluaciones</a>
                        </li>                        
                         @endif-->
                        <li class="divider"></li> 
                        <li><a href="{{route('logout')}}"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesión</a>
                        </li>
                    </ul>
                </li>
            </ul>           

            <div class="navbar-default sidebar" role="navigation">  </div>
  </nav>
</div>            
           
<div id="import-content">
  <br>
  <br>
  <br>
  @yield('content')
</div>
          
                
<footer>
  <div id="ft-text">
    <p style=""><strong>Grupo Sig</strong>        
    <i class="fa fa-phone"></i> (+57 1) PBX 7462903, 2745749     
    www.grupo-sig.com</p>

  </div>
</footer>
     @yield('script')
 
    {!!Html::script('js/bootstrap.min.js')!!}
    {!!Html::script('js/metisMenu.min.js')!!}
    {!!Html::script('js/sb-admin-2.js')!!}

   
</body>
<script>

  var petition = false;

</script>

</html>
