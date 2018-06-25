@extends('layouts.admin')



    @section('content')
      
<style>
	.thistitle{

		font-weight: bold;
		font-size: 35px;

	}
      
      .btn:hover{
          background-color: #000033;
      }
         

</style>
<br>
 
 <div class="row">
   <div class="col-lg-6">
     <form  id="f_cargar_datos_usuarios" name="f_cargar_datos_usuarios" method="post"  action="Upload/Excel" class="formarchivo" enctype="multipart/form-data" >    
   
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
   
      <div class="form-group">
          {!!Form::label('Empresa')!!}
          {!!Form::select('empresas',$empresas,null,['id'=>'empresa','class'=>'form-control','placeholder'=>'selecciona una opcion'])!!}
      </div>    
      <div class="form-group">
        {!!Form::label('Archivo')!!}
        <input name="archivo" id="archivo" type="file"   class="archivo form-control" required/>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Cargar Datos</button>
      </div>
     </form>
   </div>
   <div class="col-lg-6">
     Información de excel.
     <div class="detailedinfo"></div>
   </div>
 </div>

    	 




<script>
    $(document).ready(function() {
        $("#element").change(event => {
         if($("#element").val()==2){

                console.log('esta la condicion');
                $( "#fecha" ).prop( "disabled", false );

          }
          if($("#element").val()==1){
                 $("input[type=date]").val("");
                $( "#fecha" ).prop( "disabled", true );            
          }
        });  
      });
</script>
@stop   
