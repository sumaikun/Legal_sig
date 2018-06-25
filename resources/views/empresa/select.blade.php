     
	   {{Html::script('js/Getcumplimiento.js')}}
     {{Html::script('js/Showevaluations.js')}} 
    @if($con == 2)    
     <form method="POST" action="matrizcompleta" accept-charset="UTF-8">
    @elseif($con == 3)
      <form method="POST" action="graficasempresa" accept-charset="UTF-8">  
    @elseif($con == 4)
      <form method="POST" action="costumermatriz" accept-charset="UTF-8">  
    @else     
     {!!Form::open()!!}
    @endif 

            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

            <div class="form-group">
                @if($con !=4)
                {!!Form::label('Empresa')!!}
                {!!Form::select('empresa_id',$empresas,null,['id'=>'empresa_id','class'=>'form-control','required'])!!}
                @endif
                @if($con == 2 ||  $con == 3 || $con == 4)
            </div>    
          <div class="form-group">
                @if($con==2||$con==3)            
                {!!Form::label('Tipo')!!}
                {!!Form::select('tipo',['0' => 'Siso', '1' => 'Ambiental', '2' => 'Emergencias'],null,['id'=>'tipo','class'=>'form-control','placeholder'=>'Selecciona','required'])!!}
                @elseif($con==4)
                {!!Form::label('Tipo')!!}
                {!!Form::select('tipo',['0' => 'Siso', '1' => 'Ambiental'],null,['id'=>'tipo','class'=>'form-control','placeholder'=>'Selecciona','required'])!!}
                @endif
          </div>
                @endif  
          <div class="form-group">
                 @if($con == 3)
                {!!Form::label('Tipo de Grafica')!!}
                {!!Form::select('chart',['1' => 'Factores de Riesgo', '2' => 'General'],null,['id'=>'chart','class'=>'form-control','required'])!!}
                @endif
            </div>

      		<input type='hidden' name="idreq" id="idreq" value='{{$id}}' />

      
                @if($con == 0)  
                 {!!Link_to('#',$title='Seleccionar!',$attributes = ['id'=>'cumplimiento','class'=> 'btn btn-primary'], $secure = null)!!}
                @elseif($con == 1)
                 {!!Link_to('#',$title='Seleccionar!',$attributes = ['id'=>'observacion','class'=> 'btn btn-primary'], $secure = null)!!}
                @elseif($con == 2)
                 <input class="btn btn-primary" type="submit" value="Selecciona">
                @elseif($con == 3 || $con == 4)
               <input class="btn btn-primary" type="submit" value="Selecciona">
                @endif 
        {!!Form::close()!!}