<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoProgramaAcademicoTable extends Migration
{
    public function up()
    {
        Schema::create('proyecto_programa_academico', function (Blueprint $table) {

            $table->unsignedBigInteger('proyecto_id');
            $table->unsignedBigInteger('programa_academico_id');
            $table->foreign('programa_academico_id')->references('id')->on('programas_academicos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('proyecto_programa_academico');
    }
}
