<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNormastwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Normas', function (Blueprint $table)
          {

            $table->increments('id');
            $table->string('numero_norma');
            $table->string('descripcion_norma')->nullable();
            $table->Integer('tipo_norma_id');
            $table->Integer('yearemision_id');
            $table->Integer('autoridad_emisora_id');
            $table->Integer('clase_norma_id');//campo para especificar en que estado esta-Derogar-vigente-inf
            $table->string('norma_relacionadas');

           
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
