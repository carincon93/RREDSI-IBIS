<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemilleroDisciplinaSubareaConocimientoTable extends Migration
{
    public function up()
    {
        Schema::create('semillero_disciplina_subarea_conocimiento', function (Blueprint $table) {

            $table->unsignedBigInteger('semillero_investigacion_id');
            $table->unsignedBigInteger('disciplina_subarea_conocimiento_id');
            $table->foreign('disciplina_subarea_conocimiento_id', 'research:_team_ksd_id')->references('id')->on('disciplinas_subarea_conocimiento')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('semillero_investigacion_id', 'ksd_semillero_investigacion_id')->references('id')->on('semilleros_investigacion')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('semillero_disciplina_subarea_conocimiento');
    }
}
