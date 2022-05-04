<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudiosTable extends Migration
{
    public function up()
    {
        Schema::create('estudios', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('user_id');
            $table->string('institucion_educativa', 191);
            $table->string('programa_academico', 191);
            $table->integer('year');
            $table->boolean('graduado', 2)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('estudios');
    }
}
