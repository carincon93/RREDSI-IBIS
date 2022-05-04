<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoDisciplinaSubareaConocimientoTable extends Migration
{
    public function up()
    {
        Schema::create('proyecto_disciplina_subarea_conocimiento', function (Blueprint $table) {

            $table->unsignedBigInteger('proyecto_id');
            $table->unsignedBigInteger('disciplina_subarea_conocimiento_id');
            $table->foreign('disciplina_subarea_conocimiento_id', 'project_ksd_id')->references('id')->on('disciplinas_subarea_conocimiento')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('proyecto_disciplina_subarea_conocimiento');
    }
}
