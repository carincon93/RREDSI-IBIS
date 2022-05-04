<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajosGradoTable extends Migration
{
    public function up()
    {
        Schema::create('trabajos_grado', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('disciplina_subarea_conocimiento_id');
            $table->unsignedBigInteger('graduacion_id');
            $table->string('nombre_grupo_investigacion', 191)->nullable();
            $table->string('titulo', 191);
            $table->string('tipo', 191);
            $table->text('autores');
            $table->float('nota');
            $table->text('mentores');
            $table->timestamps();

            $table->foreign('graduacion_id')->references('id')->on('estudios')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('disciplina_subarea_conocimiento_id')->references('id')->on('disciplinas_subarea_conocimiento')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('trabajos_grado');
    }
}
