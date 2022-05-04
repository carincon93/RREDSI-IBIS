<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformacionLegalTable extends Migration
{
    public function up()
    {
        Schema::create('informacion_legal', function (Blueprint $table) {

            $table->id('id');
            $table->text('descripcion');
            $table->string('titulo', 191);
            $table->string('slug', 191)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('informacion_legal');
    }
}
