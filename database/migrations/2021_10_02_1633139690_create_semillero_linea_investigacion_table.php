<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemilleroLineaInvestigacionTable extends Migration
{
    public function up()
    {
        Schema::create('semillero_linea_investigacion', function (Blueprint $table) {

            $table->unsignedBigInteger('semillero_investigacion_id');
            $table->unsignedBigInteger('linea_investigacion_id');
            $table->foreign('linea_investigacion_id')->references('id')->on('lineas_investigacion')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('semillero_investigacion_id')->references('id')->on('semilleros_investigacion')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('semillero_linea_investigacion');
    }
}
