<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMigracionMatriz extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MigracionMatriz', function(Blueprint $table)
        {
            $table->increments('id');
            $table->Integer('id_requisito');
            $table->Integer('id_cumplimiento');
            $table->Integer('id_evaluacion');
            $table->Integer('id_usuario');
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
        Schema::drop('RequisitosMatriz');
    }
}
