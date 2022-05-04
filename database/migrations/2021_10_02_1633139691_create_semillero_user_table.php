<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemilleroUserTable extends Migration
{
    public function up()
    {
        Schema::create('semillero_user', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('semillero_investigacion_id');
            $table->text('comentario')->nullable();
            $table->datetime('aceptado_en')->nullable();
            $table->datetime('retirado_en')->nullable();
            $table->string('externo', 5);
            $table->string('carta_autorizacion')->nullable();
            $table->foreign('semillero_investigacion_id')->references('id')->on('semilleros_investigacion')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('semillero_user');
    }
}
