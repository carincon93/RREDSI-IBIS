<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectosTable extends Migration
{
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('tipo_proyecto_id');
            $table->text('titulo');
            $table->date('fecha_inicio');
            $table->date('fecha_finalizacion');
            $table->text('resumen');
            $table->text('palabras_clave');
            $table->string('file')->nullable();
            $table->text('objetivo_general');
            $table->string('privado', 5);
            $table->string('publicado', 5);
            $table->text('descripcion_requerimiento_rol')->nullable();
            $table->text('requerimientos_equipos_descripcion')->nullable();
            $table->text('requerimientos_roles')->nullable();
            $table->text('requerimientos_equipos')->nullable();
            $table->string('main_image', 191)->nullable();
            $table->timestamps();

            $table->foreign('tipo_proyecto_id')->references('id')->on('tipos_proyecto')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('proyectos');
    }
}
