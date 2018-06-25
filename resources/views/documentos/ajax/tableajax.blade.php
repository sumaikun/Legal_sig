<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead>
    <tr class=table_head>
       <th>Mes</th>    
       <th>Título</th> 
       <th>Adjunto</th>
       @if(Auth::user()->rol_id==1)
        <th>Anexo</th>
       @endif
       <th>Usuario</th>
       <th>Empresa</th>
       <th>Boton</th>                 
    </tr>  
  </thead>
  <tbody>

    @foreach($documentos as $documento)
    <tr>
    <td>  {{Sig\Helpers\Externclass::month_name($documento->mes)}}  </td>                
    <td>  {{$documento->nombre}} </td>
    <td>  <a  href="downloaddocumento/{{$documento ->archivo}}" >{{Sig\Helpers\Externclass::clean_name_doc($documento->archivo)}}</a></td>
    @if(Auth::user()->rol_id==1)
      <td> @if($documento ->anexo != null) <a href="downloadanexo/{{$documento ->anexo}}">Anexo</a> @endif</td>
    @endif
    <td> {{Sig\Helpers\Externclass::user_name($documento->user)}}</td>        
    <td>  {{$documento->empresas->nombre}} </td> 
    @if(Auth::user()->rol_id!=3)
    <td>
    <button href="#"  class="btn btn-warning boletinedit" value="{{$documento->id}}" data-target='#myModal' data-toggle='modal' onclick="ajaxfunct({{$documento->id}})">Editar</button>
    </td> 
    @else
    <td></td>
    @endif
    </tr>  
    @endforeach  
  </tbody>         	
</table> 