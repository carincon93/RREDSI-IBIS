<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosNodoTable extends Migration
{
    public function up()
    {
        Schema::create('eventos_nodo', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('nodo_id');
            $table->string('evento_anual', 5)->nullable();
            $table->timestamps();

            $table->foreign('id')->references('id')->on('eventos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('nodo_id')->references('id')->on('nodos')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('eventos_nodo');
    }
}
