<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemilleroProgramaAcademicoTable extends Migration
{
    public function up()
    {
        Schema::create('semillero_programa_academico', function (Blueprint $table) {

            $table->unsignedBigInteger('semillero_investigacion_id');
            $table->unsignedBigInteger('programa_academico_id');
            $table->foreign('programa_academico_id')->references('id')->on('programas_academicos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('semillero_investigacion_id')->references('id')->on('semilleros_investigacion')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('semillero_programa_academico');
    }
}
