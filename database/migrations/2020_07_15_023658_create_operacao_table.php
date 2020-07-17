<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operacao', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data_operacao');
            $table->string('tipo_operacao',255);
            $table->integer('quantidade');
            $table->double('valor');
            $table->integer('usuario_id')->nullable()->unsigned();
            $table->integer('corretora_id')->nullable()->unsigned();
            $table->integer('papel_id')->nullable()->unsigned();
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');;
            $table->foreign('corretora_id')->references('id')->on('corretora')->onDelete('cascade');;
            $table->foreign('papel_id')->references('id')->on('papel')->onDelete('cascade');;
            $table->softDeletes();
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
        Schema::dropIfExists('operacao');
    }
}
