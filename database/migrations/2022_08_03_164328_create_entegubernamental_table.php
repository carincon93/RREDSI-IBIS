<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntegubernamentalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entegubernamental', function (Blueprint $table) {
            $table->string('nombre', 20);
            $table->integer('nit',20);
            $table->integer('telefono',10);
            $table->string('ciudad',20);
            $table->text('direccion',100);
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
        Schema::dropIfExists('entegubernamental');
    }
}
