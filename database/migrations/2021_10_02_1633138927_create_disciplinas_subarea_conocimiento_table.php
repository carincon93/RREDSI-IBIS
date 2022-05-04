<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisciplinasSubareaConocimientoTable extends Migration
{
    public function up()
    {
        Schema::create('disciplinas_subarea_conocimiento', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('subarea_conocimiento_id');
            $table->string('nombre', 191);
            $table->timestamps();

            $table->foreign('subarea_conocimiento_id')->references('id')->on('subareas_conocimiento')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('disciplinas_subarea_conocimiento');
    }
}
