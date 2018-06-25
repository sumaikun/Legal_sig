<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Setnullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('RequisitosMatriz', function(Blueprint $table)
        {
            
            $table->string('FactorRiesgo')->nullable()->change();;
            $table->string('Grupo')->nullable()->change();;
            $table->string('CategoriaRiesgo')->nullable()->change();;
            $table->string('TipoNorma')->nullable()->change();;
            $table->string('Numero')->nullable()->change();;
            $table->string('AñoEmision')->nullable()->change();;
            $table->string('AutoridadEmite')->nullable()->change();;
            $table->string('ArticuloAplica')->nullable()->change();;
            $table->string('LitNum')->nullable()->change();;
            $table->String('NormasRelacionadas')->nullable()->change();;
            $table->String('Norma')->nullable()->change();;
            $table->String('Tema')->nullable()->change();;
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
