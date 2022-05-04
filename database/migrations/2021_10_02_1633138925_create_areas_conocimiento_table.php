<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasConocimientoTable extends Migration
{
    public function up()
    {
        Schema::create('areas_conocimiento', function (Blueprint $table) {

            $table->id('id');
            $table->string('nombre', 191);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('areas_conocimiento');
    }
}
