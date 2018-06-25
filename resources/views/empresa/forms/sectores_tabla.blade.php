  <table class ="table">
            <thead>
              <tr class="table_head">
                <th> Sector</th>
                <th> </th> 
                <th> </th>                          
              </tr>  
             </thead>
  
             <tbody>
             
             @foreach($sectors as $sector)
             <tr>         
                <td>{{$sector->sector}}</td>             
                <td>                  
                  <button type="button" class="btn btn-warning Sedit"  onclick="object.setid({{$sector->idsector}})" data-target='#myModal' data-toggle='modal'>Editar</button>                  
               </td>
                <td>
                  <a href="{{route('Sector.delete',$sector->idsector)}}">
                  <button type="button" class="btn btn-danger">Borrar</button>
                  </a>
                </td>                 
             </tr>           
             @endforeach
            {{$sectors->render()}}     
           </tbody> 
        </table>