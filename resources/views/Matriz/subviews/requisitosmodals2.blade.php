
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>Cumplimiento
            </h4>
         </div>
         <div class="modal-body">
         <style>
          .fix_headerborder{
            border-bottom: 2px solid black !important;
          }
         </style>              
            <div class="row">  
              <div class="col-lg-12">
                <table  style="font-size: 75%;" class="table">
          <thead>
           <tr>
                  <th class="fix_headerborder">Normas relacionadas</th>
                  <th class="fix_headerborder">Requisito Legal</th>             
                  <th class="fix_headerborder">Clase</th>
                  <th class="fix_headerborder">Evidencia<br>esperada </th>
                  <th class="fix_headerborder">Responsable </th>
                  <th class="fix_headerborder">Area </th>
                  <th class="fix_headerborder"></th>
              </tr>
            </thead>
            <tbody>
              <td id="relacionada" contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"></td>
               <td id="reqlegal" contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"></td>
               <td id="clase"></td>
               <td id="evidencia" contenteditable="true" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"></td>
               <td id="responsable" contenteditable="true" ></td>
               <td id="area" contenteditable="true"></td>
               <td></td>
            </tbody>
        </table>        
              </div>
            </div>      
         </div>
         <input type="hidden" id="cump_id">
         <div class="modal-footer">
             
            <button type="button"  class="btn btn-default" data-dismiss="modal">Cerrar</button>     
         </div>
      </div>
   </div>
</div>


<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-plus-square-o"></i>Evaluación
            </h4>
         </div>
         <div class="modal-body">
         <style>
          .fix_headerborder{
            border-bottom: 2px solid black !important;
          }
         </style>              
            <div class="row">  
              <div class="col-lg-12">
                <table  style="font-size: 75%;" class="table">
                    <thead>
                        <tr>
                            <th class="fix_headerborder">Fecha</th>             
                            <th class="fix_headerborder">Evidencia</th>
                            <th class="fix_headerborder">Calificacion </th>
                            <th class="fix_headerborder">Proxima evaluacion </th>                      
                        </tr>
                      </thead>
                      <tbody>
                         <td id="fecha"></td>
                         <td id="cumpevidencia" contenteditable="false" onclick="big_text_edit(this)" onblur="big_text_edit_over(this)"></td>
                         <td id="calif"></td>
                         <td id="proxfecha" contenteditable="false" ></td>                         
                      </tbody>
                  </table>
                  <div id="eval_table_ajax"></div>        
              </div>
            </div>      
         </div>
         <div class="modal-footer">
            <button type="button"  id="close_category" class="btn btn-default" data-dismiss="modal">Cerrar</button>    
         </div>
      </div>
   </div>
</div>