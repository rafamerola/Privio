<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorretorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corretora', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',255);
            $table->softDeletes();
            $table->integer('usuario_id')->nullable()->unsigned();
            $table->timestamps();
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corretora');
    }
}
