<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposFormacionTable extends Migration
{
    public function up()
    {
        Schema::create('equipos_formacion', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('ambiente_formacion_id');
            $table->string('nombre', 191);
            $table->text('descripcion');
            $table->integer('qty');
            $table->timestamps();

            $table->foreign('ambiente_formacion_id')->references('id')->on('ambientes_formacion')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipos_formacion');
    }
}
