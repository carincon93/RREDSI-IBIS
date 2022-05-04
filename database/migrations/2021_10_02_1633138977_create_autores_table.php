<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoresTable extends Migration
{
    public function up()
    {
        Schema::create('autores', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('proyecto_id');
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('autores');
    }
}
