<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdeasEmpresaTable extends Migration
{
    public function up()
    {
        Schema::create('ideas_empresa', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('empresa_id');
            $table->string('nombre', 250);
            $table->text('descripcion');
            $table->string('tipo', 250);
            $table->string('tiene_equipos', 5)->nullable();
            $table->string('equipos', 250)->nullable();
            $table->string('tiene_recursos', 5)->nullable();
            $table->bigInteger('recursos')->nullable();
            $table->string('condicion', 250);
            $table->string('es_publica', 5)->nullable();
            $table->timestamps();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ideas_empresa');
    }
}
