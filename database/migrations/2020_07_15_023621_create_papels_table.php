<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papel', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sigla',255);
            $table->string('descricao',255);
            $table->softDeletes();
            $table->integer('usuario_id')->nullable()->unsigned();
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');;
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
        Schema::dropIfExists('papel');
    }
}
