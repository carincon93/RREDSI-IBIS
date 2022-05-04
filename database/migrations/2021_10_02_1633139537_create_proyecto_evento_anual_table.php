<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoEventoAnualTable extends Migration
{
    public function up()
    {
        Schema::create('proyecto_evento_anual', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('evento_nodo_id');
            $table->unsignedBigInteger('primer_ponente_id')->nullable();
            $table->unsignedBigInteger('segundo_ponente_id')->nullable();
            $table->unsignedBigInteger('proyecto_id')->nullable();
            $table->string('tipo_presentacion', 191);
            $table->string('estado_proyecto', 191)->nullable();
            $table->string('carta_aval', 191);
            $table->string('articulo_proyecto', 191);
            $table->string('estado', 5)->nullable();
            $table->text('comentarios')->nullable();
            $table->timestamps();

            $table->foreign('primer_ponente_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('evento_nodo_id')->references('id')->on('eventos_nodo')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('segundo_ponente_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('proyecto_evento_anual');
    }
}
