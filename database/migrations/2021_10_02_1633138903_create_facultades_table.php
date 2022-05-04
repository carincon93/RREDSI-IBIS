<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultadesTable extends Migration
{
    public function up()
    {
        Schema::create('facultades', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('institucion_educativa_id');
            $table->string('nombre', 191);
            $table->string('email', 191);
            $table->bigInteger('numero_telefono');
            $table->integer('ext')->nullable();
            $table->timestamps();

            $table->foreign('institucion_educativa_id', 'eif_ei_id_foreign')->references('id')->on('instituciones_educativas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('facultades');
    }
}
