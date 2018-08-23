<!DOCTYPE html>

<html lang="en">

<head>

    <script>
  
    var global_url = "{{ url('/') }}";

    </script>

    {{Html::script('js/jquery-1.8.3.js')}}
    {{Html::script('js/jquery.min.js')}}

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>

    {!!Html::style('css/bootstrap.min.css')!!}
    {!!Html::style('css/loader.css')!!}
    {!!Html::style('css/metisMenu.min.css')!!}
    {!!Html::style('css/sb-admin-2.css')!!}
    {!!Html::style('css/font-awesome.min.css')!!}
    {!!Html::style('css/bootstrap3-wysihtml5.min.css')!!}
    {!!Html::style('css/overlay.css')!!}
      @yield('css')
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
    {{Html::script("js/Controllers/CrudController.js")}}
    {{Html::script("js/Controllers/MatrizController.js")}}

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
   <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

</head>
<style>
#page-wrapper{
  margin-top: -0.6em;

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



<body ng-app="Appi">

    <div class="popup loading" style="display: none;">
      <div>
        <p style="text-align:center">
          <img src="{{ url('/') }}/gif/LoadingAjax.gif"/>REQLEGAL...
        </p>
      </div>
    </div>
    


    <div id="wrapper">

        
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                @if(Auth::user()->rol_id == 1)
                <a class="navbar-brand">Administrador</a>
                @endif
                 @if(Auth::user()->rol_id == 2)
                <a class="navbar-brand">Consultor</a>
                @endif
                 @if(Auth::user()->rol_id == 3)
                <a class="navbar-brand">Cliente</a>
                @endif
            </div>

   


            
            <!--fin de Ventana Modal -->
            <div  ng-controller="BrainController" ng-init="verify_first_asistant_view()">
              <!--<button ng-click="test()">test</button>-->
              @if(Auth::user()->rol_id != 3)
              <div class="modal fade" id="myModaltest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">
                        Notificación
                      </h4>
                    </div>
                    <div class="modal-body" ng-include="(modal.view)">
                     
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="verify_first_asistant_view_watched()">Entendido</button>
                    </div>
                  </div>
                </div>
              </div>
              @endif

              @if(Auth::user()->rol_id != 3)
              <div class="modal fade" id="myModalOperator" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">
                        Notificación
                      </h4>
                    </div>
                    <div class="modal-body table-responsive"  style="max-height:30em !important;" id="ajax-operator-content">
                     
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                      
                    </div>
                  </div>
                </div>
              </div>
              @endif

              @if(Auth::user()->rol_id != 3)
              <div class="modal fade" id="myModalOperator2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">
                        Arreglo de requisitos
                      </h4>
                    </div>
                    <div class="modal-body"  >
                      <div class="table-responsive" id="ajax-operator-content2">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="operator_action()">Arreglar</button>
                    </div>
                  </div>
                </div>
              </div>
              @endif

              <ul class="nav navbar-top-links navbar-right">
                   @if(Auth::user()->rol_id == 1)
                   <li class="dropdown" ng-include src="'{{ url('/') }}/js/Views/asistent.html'">                      
                  </li>
                  @endif
                  <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                       {!!Auth::user()->nombre!!}<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-user">
                          <!--<li><a href="#"><i class="fa fa-gear fa-fw"></i> Ajustes</a>
                          </li>
                          <li class="divider"></li>
                          <li><a href="/evaluations"><i class="fa fa-gear fa-fw"></i>Mis evaluaciones</a>
                          </li>
                          -->
                          <li class="divider"></li>
                          <li><a href="{{route('logout')}}"><i class="fa fa-sign-out fa-fw"></i>Cerrar Sesión</a>
                          </li>
                      </ul>
                  </li>
              </ul>
            </div>
            

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">

                     <li>
                      <a href="{{route('admin')}}"><i class="fa fa-home"></i>Home</a>
                     </li>

                    @if(Auth::user()->rol_id == 1)
                     <li>
                        <a href="#"><i class="fa fa-users fa-fw" aria-hidden="true"></i> Usuario<span class="fa arrow"></span>
                        </a>
                        
                        <ul class="nav nav-second-level">     
                          
                          <li>
                             <a href="{{route('Usuario.index')}}"><i class='fa fa-plus-circle'></i>Visualizar</a>
                          </li>

                          <li>
                              <a href="{{route('permission')}}"><i class='fa fa-binoculars'></i>Administrar Permisos</a>
                          </li>

                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-building" aria-hidden="true"></i> Empresa<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                         <li>
                              <a href="{{route('Empresa.create')}}"><i class='fa fa-plus-circle'></i> Agregar</a>
                          </li>
                          
                          <li>
                              <a href="{{route('Empresa.index')}}"><i class='fa fa-binoculars'></i>Visualizar</a>
                          </li>

                          <li>
                              <a href="{{route('Empresa.layout')}}"><i class='fa fa-gavel'></i>Plantillas</a>
                          </li>                        
                          <li>
                              <a href="{{route('Empresa.sectorindustria')}}"><i class='fa fa-check-square-o'></i>Sector e Industria</a>
                          </li>  
                         
                        </ul>
                 </li>
                 @endif

         
                <li>
                  <a href="#"><i class="fa fa-check-square-o" aria-hidden="true"></i>Matriz<span class="fa arrow"></span></a>

                  <ul class="nav nav-second-level">                 

                    <li>
                        <a href="{{route('matriz.matrices')}}"><i class='fa fa-gavel'></i>Matrices</a>
                    </li>

                   @if(Auth::user()->rol_id == 1)    
                    <li>
                        <a href="{{route('matriz.version4')}}"><i class='fa fa-gavel'></i>Matrices version 4</a>
                    </li>
                  @endif

                  @if(Auth::user()->rol_id != 3) 
                    <li>
                        <a href="{{route('matriz.arreglos')}}"><i class='fa fa-cubes'></i>Registros a corregir</a>
                    </li>                             
                  @endif

                  @if(Auth::user()->rol_id != 3) 
                    <li>
                        <a href="{{route('matriz.herramientas')}}"><i class='fa fa-check'></i>Herramientas</a>
                    </li>                             
                  @endif


                  @if(Auth::user()->rol_id != 3)  

                    <li>
                        <a href="{{route('matriz.graficas')}}"><i class="fa fa-bar-chart" aria-hidden="true"></i>Gráficas</a>
                    </li>

                  @endif
                  </ul>
               </li>
               
                <li>
                   <a href="{{route('documentos')}}"><i class='fa fa-newspaper-o'></i> Documentos</a>
                </li>                    

               @if(Auth::user()->rol_id == 1) 
                
                <li>
                    <a href="{{route('Mail')}}"><i class="fa fa-envelope-o" ></i> Correos</a>
                </li>

                <li>
                    <a href="{{route('Excel')}}"><i class='fa fa-gavel'></i>Excel</a>
                </li>   
             
              @endif

                <!--<li> 
                       <a href="/chart"><i class="fa fa-bar-chart" aria-hidden="true"></i>Graficas<span class="fa arrow"></span></a>
                  
                </li>-->

                    </ul>
                 </div>
            </div>

     </nav>

        <div id="page-wrapper">
            @yield('content')
        </div>

    </div>
    
     @yield('script')
   <!-- {!!Html::script('js/jquery.min.js')!!}-->
    
    {!!Html::script('js/bootstrap.min.js')!!}
    {!!Html::script('js/metisMenu.min.js')!!}
    {!!Html::script('js/sb-admin-2.js')!!}

    <footer>
      <div id="ft-text">
        <p style=""><strong>Grupo Sig</strong></p>        
        <p><i class="fa fa-phone"></i>  (+57 1) 2745749</p>     
        <p>www.grupo-sig.com</p>

      </div>
    </footer>
</body>

<script>

  var petition = false;

</script>

@include('Matriz.subviews.requisitosmodals2');
</html>
