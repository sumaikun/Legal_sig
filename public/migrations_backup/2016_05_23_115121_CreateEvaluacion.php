<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('Evaluacion', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('Fecha');
            $table->Integer('Calificacion');
            $table->string('EvidenciaCumplimiento');
            $table->Integer('id_Requisito');
            //se que se escribe responsable pero ya habia creado la tabla nada que hacer :( 
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
