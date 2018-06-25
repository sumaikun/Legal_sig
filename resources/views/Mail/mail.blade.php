@extends('layouts.admin')


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
  

<section class="content-header ">
  <br>
  <h4> <i class="fa fa-list-ul"></i> Correos pendientes </h4>
  <ol class="breadcrumb">
  <div class="table-responsive ">
 <div class="box box-primary" style="max-width:700px !important;">
  <div class="box-header with-border">
    <h3 class="box-title">Correos</h3>          
  </div>        
   <table id="example" class="table table-striped table-bordered " cellspacing="0" width="100%">
    <thead>
        <tr class=table_head>
          <th>Empresa</th>
        	<th>Fecha</th>
         	<th>Asunto</th>
         	<th style="text-align: center;">Info. Relacionada</th>      
         	<th style="text-align: center;"> Opciones </th>                                
        </tr>  
    </thead>
    <tbody>
    	@foreach($correos as $correo)  
       		<tr>
            <td> @if(isset($correo->empresas->nombre)) {{$correo->empresas->nombre}} @endif</td>
       			<td> {{$correo->created_at}} </td>
       			<!--
       			<td>Actualización de documentos</td>
       			<td> Sig\Helpers\Externclass::doc_name($correo->id_proceso) </td>
       			-->
       			<td>Proximas evaluaciones a vencerse</td>
       			<td> prox eval {{$correo->id_proceso}} </td>
				
				<td><button title="enviar" onclick="sendmail({{$correo->id}},'{{$correo->id_proceso}}',{{$correo->empresa}})" ><i class="fa fa-paper-plane" aria-hidden="true"></i></button><a href="Correo/delete_mail/{{$correo->id}}" onclick="return confirm('¿Eliminar correo?')"><button title="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></button></a></td>
       		</tr>
       	@endforeach
    </tbody>      
  </table>

  </div>
  </div>
  </ol>
  </section>
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
  <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
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
</script>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Mandar correo</h4>
      </div>
      <div class="modal-body">
        <div id="ajax-content"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" onclick="get_html_email()">Enviar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>

var action = "";

var fecha;

var empresa;

function sendmail(id,ifecha,iempresa)
{
  vfecha = ifecha;
  empresa = iempresa;
  console.log(vfecha);
	$.get(`look_by_form/`+id, function(res){              
      	$("#ajax-content").empty();
        $("#ajax-content").append(res);
        $("#myModal").modal('show');
        $("#emailid").val(id);
        tipo_e = $("input[name='tipo_e']").val();
        console.log("soy tipo e "+tipo_e);
         if(tipo_e == "documento")
         {
            action = "sendemail";
         }
         else{
            action = "sendemail2";
         }         
      });

      
}

function get_html_email()
{
    if(action=="sendemail2")
    {
         $.post( "sendemail2",{_token:'{{ csrf_token() }}',html:$('.wysihtml5-sandbox').contents().find('body').outerHTML(),
          consultores:$("#consultores").is(":checked"),clientes:$("#clientes").is(":checked"),emailid:$("#emailid").val()},function( data ){
            alert("mensaje enviado");
          });
          //var html  = $('.wysihtml5-sandbox').contents().find('body').outerHTML();
          //console.log(html);   
    }
   
}      

jQuery.fn.outerHTML = function() {
  return jQuery('<div />').append(this.eq(0).clone()).html();
};

</script>

@stop