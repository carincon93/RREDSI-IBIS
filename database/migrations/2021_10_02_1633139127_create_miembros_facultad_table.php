<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiembrosFacultadTable extends Migration
{
    public function up()
    {
        Schema::create('miembros_facultad', function (Blueprint $table) {

            $table->unsignedBigInteger('facultad_id');
            $table->unsignedBigInteger('user_id');
            $table->string('principal', 5);
            $table->foreign('facultad_id', 'eef_id')->references('id')->on('facultades')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('miembros_facultad');
    }
}
