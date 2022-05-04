<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbienteDisciplinaSubareaConocimientoTable extends Migration
{
    public function up()
    {
        Schema::create('ambiente_disciplina_subarea_conocimiento', function (Blueprint $table) {

            $table->unsignedBigInteger('ambiente_formacion_id');
            $table->unsignedBigInteger('disciplina_subarea_conocimiento_id');
            $table->foreign('ambiente_formacion_id', 'ee_id')->references('id')->on('ambientes_formacion')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('disciplina_subarea_conocimiento_id', 'ksd_id')->references('id')->on('disciplinas_subarea_conocimiento')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ambiente_disciplina_subarea_conocimiento');
    }
}
