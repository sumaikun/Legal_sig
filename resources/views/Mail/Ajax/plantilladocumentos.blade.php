<h4>Actualización de documentos</h4>
<div class="form-group">
	<label>Mensaje</label>	
	<textarea name="mensaje" class="form-control"></textarea>	
</div>
<input type="hidden" name="tipo_e" value="documento">
<input type="hidden" name="emailid" id="emailid">
{{csrf_field()}}