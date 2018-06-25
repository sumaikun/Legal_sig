<table class ="table" id="tb-industrias">
            <thead>
              <tr class="table_head">
                <th> Industria</th>
                <th> Sector</th> 
                <th> </th>
                <th> </th>          
              </tr>  
             </thead>
  
             <tbody>
             
             @foreach($industrias as $industria)
             <tr>         
                <td>{{$industria->industria}}</td>
                <td>{{Sig\Helpers\Exception_manager::arrayExcept($sectores,$industria->sector_id)}} </td>            
                <td>                  
                  <button type="button" class="btn btn-warning Iedit"  onclick="object.setid({{$industria->idindustria}})" data-target='#myModal' data-toggle='modal'>Editar</button>                  
               </td>
                <td>
                  <a href="deleteIndustria/{{$industria->idindustria}}">
                  <button type="button" class="btn btn-danger ">Borrar</button>
                  </a>
                </td>                 
             </tr>           
             @endforeach
            {{$industrias->render()}}     
           </tbody> 
        </table> 