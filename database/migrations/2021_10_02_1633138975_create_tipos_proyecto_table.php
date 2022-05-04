<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposProyectoTable extends Migration
{
    public function up()
    {
        Schema::create('tipos_proyecto', function (Blueprint $table) {

            $table->id('id');
            $table->string('tipo', 191);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipos_proyecto');
    }
}
