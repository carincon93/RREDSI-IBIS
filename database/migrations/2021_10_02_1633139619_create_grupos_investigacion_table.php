<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposInvestigacionTable extends Migration
{
    public function up()
    {
        Schema::create('grupos_investigacion', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('facultad_id');
            $table->string('nombre', 191);
            $table->string('email', 191);
            $table->string('lider', 191);
            $table->string('gruplac', 191)->nullable();
            $table->string('codigo_minciencias', 191);
            $table->string('categoria_minciencias', 10)->nullable();
            $table->string('sitio_web', 191)->nullable();
            $table->timestamps();

            $table->foreign('facultad_id')->references('id')->on('facultades')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('grupos_investigacion');
    }
}
