<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNodosTable extends Migration
{
    public function up()
    {
        Schema::create('nodos', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('administrador_id');
            $table->string('departamento', 191);
            $table->string('logo', 191)->nullable();
            $table->timestamps();

            $table->foreign('administrador_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nodos');
    }
}
