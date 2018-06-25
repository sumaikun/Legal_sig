<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAspectoAmbiental extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
               Schema::create('AspectoAmbiental', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('nombre');
          
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
