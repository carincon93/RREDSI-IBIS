<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestasTable extends Migration
{
    public function up()
    {
        Schema::create('respuestas', function (Blueprint $table) {

            $table->id('id');
            $table->text('titulo');
            $table->text('descripcion')->nullable();
            $table->text('documento')->nullable();
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('idea_empresa_id');
            $table->timestamps();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('idea_empresa_id')->references('id')->on('ideas_empresa')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('respuestas');
    }
}
