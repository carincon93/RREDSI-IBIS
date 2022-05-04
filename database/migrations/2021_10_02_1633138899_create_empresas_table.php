<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {

            $table->id('id');
            $table->string('nombre');
            $table->string('nit');
            $table->string('direccion');
            $table->bigInteger('numero_celular');
            $table->string('email');
            $table->string('autorizacion_datos', 5);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
