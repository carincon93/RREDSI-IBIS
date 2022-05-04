<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramasAcademicosTable extends Migration
{
    public function up()
    {
        Schema::create('programas_academicos', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('facultad_id');
            $table->string('nombre', 191);
            $table->string('codigo', 191)->nullable();
            $table->string('nivel_academico', 191);
            $table->string('modalidad', 191);
            $table->string('jornada', 191);
            $table->date('fecha_inicio');
            $table->date('fecha_finalizacion');
            $table->timestamps();

            $table->foreign('facultad_id')->references('id')->on('facultades')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('programas_academicos');
    }
}
