        <style>
            .title{
                font-size: 200%;
                font-weight: bold;
             
            }
        </style>
        <style>
        #submit{
        visibility: hidden;
        }   
        </style>

        <h4> <i class="fa fa-list-ul"></i> Evaluacion </h4>
        {{Html::script('js/setEvaluacion.js')}}

     {!!Form::open(['id'=>'insideform'])!!}

                <input type='hidden' name="idreq" id="idreq" value='<?php echo $id ?>' />

                <input type='hidden' name="idempresa" id="idempresa" value='<?php echo $num ?>' />
  
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
     

         <div class="form-group">
                {!!Form::label('Evidencia de Cumplimiento')!!}
                {!!Form::textarea('evidenciacump',null,['id'=>'evidenciacump','class'=>'form-control','placeholder'=>'Ingrese la evidencia de cumplimiento','style'=>'max-height: 100px !important;' ,'maxlength'=>'2500','required','minlength'=>'30'])!!}
         </div>

         <div class="form-group">
            <span class="title">Calificación</span>
            <br> @if($tipoEvaluacion==1)

                {!!Form::label('0')!!}
                {!!Form::radio('calificacion', '0',['required'])!!}
                {!!Form::label('100')!!}
                {!!Form::radio('calificacion', '100')!!}

                @else
                {!!Form::label('0')!!}
                {!!Form::radio('calificacion', '0',['required'])!!}
                {!!Form::label('50')!!}
                {!!Form::radio('calificacion', '50')!!}
                {!!Form::label('100')!!}
                {!!Form::radio('calificacion', '100')!!}

                @endif
            </div>  
         <div class="form-group">
                {!!Form::label('Fecha Proxima evaluación')!!}
                {!!Form::date('fechaprox',null,['id'=>'fechaprox','class'=>'form-control','required'])!!}
        </div>
         </div>

               @if(strtoupper(Sig\Helpers\Externclass::corp_name($num))=='SCHLUMBERGER')
                    @include('Evaluacion.especifico_schlumberger.schlumberger')
                @endif

           {!!Form::submit('Registrar',['class'=>'btn btn-primary ','id'=>'submit'])!!}
             
                {!!Link_to('#',$title='REGISTRAR!',$attributes = ['id'=>'setEvaluacion','class'=> 'btn btn-primary'], $secure = null)!!}
                
        {!!Form::close()!!}

{{Sig\Helpers\Externclass::corp_name($num)}}