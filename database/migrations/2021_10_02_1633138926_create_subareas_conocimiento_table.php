<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubareasConocimientoTable extends Migration
{
    public function up()
    {
        Schema::create('subareas_conocimiento', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('area_conocimiento_id');
            $table->string('nombre', 191);
            $table->timestamps();

            $table->foreign('area_conocimiento_id')->references('id')->on('areas_conocimiento')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subareas_conocimiento');
    }
}
