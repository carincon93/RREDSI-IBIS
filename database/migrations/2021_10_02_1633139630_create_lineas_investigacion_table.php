<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineasInvestigacionTable extends Migration
{
    public function up()
    {
        Schema::create('lineas_investigacion', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('area_conocimiento_id');
            $table->unsignedBigInteger('grupo_investigacion_id');
            $table->string('nombre', 191);
            $table->text('objetivos');
            $table->text('mision');
            $table->text('vision');
            $table->text('logros');
            $table->timestamps();

            $table->foreign('area_conocimiento_id')->references('id')->on('areas_conocimiento')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('grupo_investigacion_id')->references('id')->on('grupos_investigacion')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lineas_investigacion');
    }
}
