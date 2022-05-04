<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbientesFormacionTable extends Migration
{
    public function up()
    {
        Schema::create('ambientes_formacion', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('facultad_id')->nullable();
            $table->string('nombre', 191);
            $table->string('tipo', 191);
            $table->integer('capacidad_aprox');
            $table->text('descripcion')->nullable();
            $table->timestamps();

            $table->foreign('facultad_id', 'eif_id')->references('id')->on('facultades')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ambientes_formacion');
    }
}
