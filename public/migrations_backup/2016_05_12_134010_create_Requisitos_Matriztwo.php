<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisitosMatriztwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
    {
        Schema::create('RequisitosMatriz', function (Blueprint $table) {

            $table->increments('id');
            $table->string('FactorRiesgo')->default("NO APLICA");
            $table->string('Grupo')->default("NO APLICA");
            $table->string('CategoriaRiesgo')->default("NO APLICA");
            $table->string('TipoNorma')->default("NO APLICA");
            $table->string('Numero')->default("NO APLICA");
            $table->string('AñoEmision')->default("NO APLICA");
            $table->string('AutoridadEmite')->default("NO APLICA");
            $table->string('ArticuloAplica')->default("NO APLICA");
            $table->string('LitNumInPa')->default("NO APLICA");
            $table->String('NormasRelacionadas')->default("NO APLICA");
            $table->String('Norma')->default("NO APLICA");
            $table->String('Tema')->default("NO APLICA");
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            
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
