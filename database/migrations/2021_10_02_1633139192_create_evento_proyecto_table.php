<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventoProyectoTable extends Migration
{
    public function up()
    {
        Schema::create('evento_proyecto', function (Blueprint $table) {

            $table->unsignedBigInteger('evento_id');
            $table->unsignedBigInteger('proyecto_id');
            $table->foreign('evento_id')->references('id')->on('eventos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('evento_proyecto');
    }
}
