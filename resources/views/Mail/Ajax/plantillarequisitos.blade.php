<h4>Tiene requisitos legales vencidos o próximos a vencerse</h4>
<div class="box">
    <div class="box-header">
      <h3 class="box-title"><small>SIG</small></h3>
      <!-- tools box -->
      <div class="pull-right box-tools">
        
      </div><!-- /. tools -->
    </div><!-- /.box-header -->
    <div class="box-body pad">
      <!--<form method="post" action="/Correo/testmail">-->
      	    	
        <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
        
      <!--</form>-->
    </div>
  </div>
<div class="form-group">
	Consultores	
	<input type="checkbox" id="consultores" name="consultores" required>
	Clientes
	<input type="checkbox" id="clientes" name="clientes" required>	
</div>
<input type="hidden" name="tipo_e" value="requisitos">
<input type="hidden" id="emailid" name="emailid" id="emailid">
{{csrf_field()}}

{{Html::script('js/bootstrap3-wysihtml5.all.min.js')}}
<script>

$(".textarea").wysihtml5();

var requiredCheckboxes = $(':checkbox[required]');

requiredCheckboxes.change(function(){
    if(requiredCheckboxes.is(':checked')) {
        requiredCheckboxes.removeAttr('required');
    }
    else {
        requiredCheckboxes.attr('required', 'required');
    }
});

var limit = 0;

$('.wysihtml5-sandbox').contents().find('body').click(function(){
	if(limit != 1)
	{
		limit = 1;
    
    $.post("info_plantilla_requisitos", {empresa:empresa,fecha:vfecha,_token:"{{ csrf_token() }}"} ,function(data){
         $('.wysihtml5-sandbox').contents().find('body').append(data);  
    });

		
	}	
});
//$('.wysihtml5-sandbox').contents().find('body').html('<p><img src="http://grupo-sig.com/images/werwer.png" title="Image: http://grupo-sig.com/images/werwer.png"><br></p>');
</script>