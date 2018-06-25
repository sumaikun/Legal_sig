<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Articulos', function (Blueprint $table)
          {

            $table->increments('id');
            $table->string('numero_articulo');
            $table->string('literal_numeral')->nullable();
            $table->Integer('numero_norma_id');
            $table->String('Estado_del_Articulo');
            //agregar columna para derogar
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
