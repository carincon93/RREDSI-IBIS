<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoSemilleroInvestigacionTable extends Migration
{
    public function up()
    {
        Schema::create('proyecto_semillero_investigacion', function (Blueprint $table) {

            $table->unsignedBigInteger('proyecto_id');
            $table->unsignedBigInteger('semillero_investigacion_id');
            $table->string('principal', 5);
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('semillero_investigacion_id', 'proyecto_si_id')->references('id')->on('semilleros_investigacion')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('proyecto_semillero_investigacion');
    }
}
