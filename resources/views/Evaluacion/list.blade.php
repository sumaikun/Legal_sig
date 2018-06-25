   <style>
        .boton{
          font-size: 90%;
       
        }
        .Cump{
            text-align: center;
            font-size: 80%;
        }

        .col2E{

            width:600px;
            text-align: justify;
            text-justify: inter-word;
        }

        .col1E{

            width:700px;
            text-align: justify;
            text-justify: inter-word;
        }

        .col3E{

            width:100px;
            text-align: center;
        }
        .back
        {
          margin-top: -500px;
        }
   </style>

    {{Html::script('js/GetComentario.js')}} 
    {{Html::script('js/Showevaluations.js')}}
   <section class="content-header">
    <h4> <i class="fa fa-list-ul"></i> Evaluación </h4>
    <ol class="breadcrumb">
    <div class="table-responsive ocultar_400px">
    <div id=back><a href="#" id="observacion">Devolverse</a></div>
     <table class ="table Cump">
            <thead>
                <th>Requisito Legal</th>
                <th>Clase</th>
                <th>Evidencia Esperada</th>
                <th>Area de evaluación</th>
                <th>Responsable</th>
                <th class="col1E"> Fecha  </th>
                <th class="col2"> Evidencia Cumplimiento  </th>       
                <th> Calificación </th>
                <th>Próxima Evaluación</th>
                <th></th>
             </thead>

             <?php
             //echo $num;
              foreach($consulta as $consult)
              {
                 static $i=0;
                 $consult->newproperty=$i;
                 $i++;
                 //echo $consult;
              }
             ?>
            <tbody>
            @foreach($Cumplimiento as $cump)

                <td><abbr title="{{$cump->Requisito}}">{{str_limit($cump->Requisito, $limit=50, $end="...")}}</abbr></td>
                <td>{{$claseNorma[$cump->Clase_norma_id]}}</td>
                <td><abbr title="{{$cump->EvidenciaEsperada}}">{{str_limit($cump->EvidenciaEsperada, $limit=50, $end="...")}}</abbr></td>
                <td>{{$cump->AreaAplicacion}}</td>
                <td>{{$cump->Responsable}}</td>
                
            @endforeach 
            @foreach($consulta as $consult)
            @if($consult->newproperty==$num)
            
            <?php $empresa = $consult->empresa ?>
                <td class="col1E">{{$consult->Fecha}}</td>
                <td class="col2E"><abbr title="{{$consult->EvidenciaCumplimiento}}">{{str_limit($consult->EvidenciaCumplimiento, $limit=50, $end="...")}}</abbr></td>               
                <td class="col3E">{{$consult->Calificacion}}</td>                
                <td>{{Sig\Helpers\Externclass::fechaprox($consult->id)}}</td>
                <td> 
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

                <td> 
                  <button type="button" class="btn btn-success btn-lg  boton" id="find2" onclick="gestion.setideval({{$consult->id}},{{$id}})">Comentario</button>  
                </td>
            
             @endif
             @endforeach
            </tbody>   
            
        </table> 
        <script>
        var gestion = new Object();

        gestion.ideval = 0;
        gestion.idreq = 0;
        
         gestion.setideval=function(ideval,id)
        {
            gestion.ideval = ideval;
            console.log("capture el dato "+gestion.ideval);
            gestion.idreq = id;
            console.log("capture el dato "+gestion.idreq);
        }

        //console.log("en la vista"+gestion.ideval);
        var idrequisito= '<?php  echo $id ?>'
        var idempresa= '<?php  echo $empresa ?>'
        </script>
