<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemillerosInvestigacionTable extends Migration
{
    public function up()
    {
        Schema::create('semilleros_investigacion', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('grupo_investigacion_id');
            $table->unsignedBigInteger('estudiante_lider_id')->nullable();
            $table->string('nombre', 191);
            $table->string('nombre_mentor', 191);
            $table->string('correo_mentor', 191);
            $table->bigInteger('celular_mentor');
            $table->text('objetivo_general');
            $table->text('mision');
            $table->text('vision');
            $table->text('proyeccion_regional');
            $table->text('estrategia_produccion_conocimiento');
            $table->text('tematica_investigacion');
            $table->date('fecha_creacion');
            $table->timestamps();

            $table->foreign('grupo_investigacion_id')->references('id')->on('grupos_investigacion')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('estudiante_lider_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('semilleros_investigacion');
    }
}
