<div class="form-group">
                {!!Form::label('¿Donde aplica?')!!}
                <br>
                {!!Form::label('Barranca')!!}
                {!!Form::checkbox('Barranca', 1, true, ['id'=>'Barranca']);!!}
                {!!Form::label('Cota')!!}
                {!!Form::checkbox('Cota', 1, true, ['id'=>'Cota']);!!}
                {!!Form::label('Guafilia')!!}
                {!!Form::checkbox('Guafilia', 1, true, ['id'=>'Guafilia']);!!}
                {!!Form::label('Villavicencio')!!}
                {!!Form::checkbox('Villavicencio', 1, true, ['id'=>'Villavicencio']);!!}
                {!!Form::label('Neiva')!!}
                {!!Form::checkbox('Neiva', 1, true, ['id'=>'Neiva']);!!}
                {!!Form::label('Oficinas')!!}
                {!!Form::checkbox('Oficinas', 1, true, ['id'=>'Oficinas']);!!}
                <br>
                {!!Form::label('Valoracion Harc')!!}
                <br>
                {!!Form::label('Probabilidad')!!}
                {{Form::number('prob', null,['id'=>'prob','class'=>'form-control','min'=>1,'max'=>5,'required'])}}
                {!!Form::label('Severidad')!!}
                {{Form::number('sever', null,['id'=>'sever','class'=>'form-control','min'=>1,'max'=>5,'required'])}}
        </div>