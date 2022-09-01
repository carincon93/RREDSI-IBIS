<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {

            $table->id('id');
            $table->string('nombre', 191);
            $table->string('ubicacion', 191);
            $table->text('descripcion');
            $table->date('fecha_inicio');
            $table->date('fecha_finalizacion');
            $table->string('link_registro');
            $table->string('info_link');
            $table->timestamps();
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('eventos');
    }
}
