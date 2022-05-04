<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperienciasTable extends Migration
{
    public function up()
    {
        Schema::create('experiencias', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('empresa_id');
            $table->text('titulo');
            $table->text('descripcion');
            $table->text('image')->nullable();
            $table->timestamps();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('experiencias');
    }
}
