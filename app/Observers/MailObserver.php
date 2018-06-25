<?php

 namespace Sig\Observers;

 use Sig\Models\Correo;

 use DB;

 use Cache; 
 
class MailObserver extends AbstractObserver {

    public function saved($model)
    {          
       //$last_row = $model::orderBy('id', 'desc')->first();
       $existence = Correo::where('proceso','=','documentos')->where('id_proceso','=',Cache::get('iddoc'))->where('estado','=',1)->first();
        echo 'entro al observer '.Cache::get('iddoc');
        echo '<br>';
        /*if($existence == null)
        {
           $correo = new Correo();
           $dataset = DB::select(DB::raw("select max(id) as id from Correos")); 
           $id = 1+$dataset[0]->id;       
           $correo->id =  $id;
           $correo->proceso = 'documentos';
           $correo->id_proceso = Cache::get('iddoc');
           $correo->estado = 1;
           $correo->save();
        }   */

    }
    public function deleted($model) {
       echo 'borrado';
    }

    public function saving($model) {
       echo 'actualización';
    }

}