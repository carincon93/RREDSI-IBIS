<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoEmpresaTable extends Migration
{
    public function up()
    {
        Schema::create('proyecto_empresa', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('proyecto_id');
            $table->boolean('activo');
            $table->timestamps();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('proyecto_empresa');
    }
}
