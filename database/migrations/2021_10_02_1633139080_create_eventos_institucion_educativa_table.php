<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosInstitucionEducativaTable extends Migration
{
    public function up()
    {
        Schema::create('eventos_institucion_educativa', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('institucion_educativa_id');
            $table->timestamps();

            $table->foreign('institucion_educativa_id', 'ei_id')->references('id')->on('instituciones_educativas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id')->references('id')->on('eventos')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('eventos_institucion_educativa');
    }
}
