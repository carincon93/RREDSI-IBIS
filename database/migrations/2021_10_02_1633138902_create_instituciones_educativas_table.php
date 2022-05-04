<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitucionesEducativasTable extends Migration
{
    public function up()
    {
        Schema::create('instituciones_educativas', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('administrador_id')->nullable();
            $table->unsignedBigInteger('nodo_id');
            $table->string('nombre', 191);
            $table->string('nit', 191);
            $table->string('direccion', 191);
            $table->string('ciudad', 191);
            $table->bigInteger('numero_telefono')->nullable();
            $table->string('sitio_web', 191);
            $table->timestamps();

            $table->foreign('administrador_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('nodo_id')->references('id')->on('nodos')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('instituciones_educativas');
    }
}
