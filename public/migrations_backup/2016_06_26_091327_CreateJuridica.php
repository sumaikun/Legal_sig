<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJuridica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Juridica', function(Blueprint $table)
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
        Schema::drop('Juridica');
    }
}
