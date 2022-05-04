<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvocatoriasTable extends Migration
{
    public function up()
    {
        Schema::create('convocatorias', function (Blueprint $table) {

            $table->id('id');
            $table->text('nombre');
            $table->text('entidad');
            $table->text('detalles')->nullable();
            $table->text('image')->nullable();
            $table->text('link_mas_informacion');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_finalizacion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('convocatorias');
    }
}
