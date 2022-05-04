<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipoDisciplinaSubareaConocimientoTable extends Migration
{
    public function up()
    {
        Schema::create('equipo_disciplina_subarea_conocimiento', function (Blueprint $table) {

            $table->unsignedBigInteger('equipo_formacion_id');
            $table->unsignedBigInteger('disciplina_subarea_conocimiento_id');
            $table->foreign('equipo_formacion_id', 'et_id')->references('id')->on('equipos_formacion')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('disciplina_subarea_conocimiento_id', 'ksd__id')->references('id')->on('disciplinas_subarea_conocimiento')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipo_disciplina_subarea_conocimiento');
    }
}
