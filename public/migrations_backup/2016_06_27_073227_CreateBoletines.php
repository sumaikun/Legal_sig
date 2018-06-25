<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoletines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Boletines', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('titulo');
            $table->string('archivo');
            $table->integer('usuario'); 
            $table->timestamps();          
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Boletines');
    }
}
