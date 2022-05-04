<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventoDisciplinaSubareaConocimientoTable extends Migration
{
    public function up()
    {
        Schema::create('evento_disciplina_subarea_conocimiento', function (Blueprint $table) {

            $table->unsignedBigInteger('evento_id');
            $table->unsignedBigInteger('disciplina_subarea_conocimiento_id');
            $table->foreign('evento_id')->references('id')->on('eventos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('disciplina_subarea_conocimiento_id', 'event_ksd_id')->references('id')->on('disciplinas_subarea_conocimiento')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('evento_disciplina_subarea_conocimiento');
    }
}
