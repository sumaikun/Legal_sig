<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCumplimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EstadoCumplimiento', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('Requisito');
            $table->string('EvidenciaEsperada');
            $table->string('Responzable');//se que se escribe responsable pero ya habia creado la tabla nada que hacer :( 
            $table->string('AreaAplicacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('EstadoCumplimiento');
    }
}
