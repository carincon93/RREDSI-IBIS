<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->datetime('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->string('esta_habilitado', 5);
            $table->json('intereses')->nullable();
            $table->string('tipo_documento', 2);
            $table->bigInteger('numero_documento');
            $table->bigInteger('numero_celular');
            $table->text('biografia')->nullable();
            $table->string('cvlac', 191)->nullable();
            $table->string('cv')->nullable();
            $table->boolean('autorizacion_tratamiento_datos');
            $table->timestamps();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onUpdate('cascade')->onDelete('cascade')->onUpdate('cascade')->onDelete('cascade');;
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
