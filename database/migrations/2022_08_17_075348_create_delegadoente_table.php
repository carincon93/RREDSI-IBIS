<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelegadoenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegadoente', function (Blueprint $table) {
            $table->string('nombre', 20);
            $table->integer('documento',20);
            $table->integer('celular',10);
            $table->email('email',50);
            $table->password('contraseña',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delegadoente');
    }
}
