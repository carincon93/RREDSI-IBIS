<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosInvestigacionTable extends Migration
{
    public function up()
    {
        Schema::create('productos_investigacion', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('proyecto_id');
            $table->string('titulo', 191);
            $table->string('tipologia', 191);
            $table->text('descripcion');
            $table->string('file')->nullable();
            $table->timestamps();

            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos_investigacion');
    }
}
