<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoLineaInvestigacionTable extends Migration
{
    public function up()
    {
        Schema::create('proyecto_linea_investigacion', function (Blueprint $table) {

            $table->unsignedBigInteger('proyecto_id');
            $table->unsignedBigInteger('linea_investigacion_id');
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('linea_investigacion_id')->references('id')->on('lineas_investigacion')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('proyecto_linea_investigacion');
    }
}
