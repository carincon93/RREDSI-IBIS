<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesTable extends Migration
{
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('user_id');
            $table->text('tipo_solicitud');
            $table->string('estado', 5)->nullable();
            $table->text('comentario')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
}
