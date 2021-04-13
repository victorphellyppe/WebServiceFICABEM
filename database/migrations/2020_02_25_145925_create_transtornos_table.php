<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranstornosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transtornos', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->string('descricao');
            $table->timestamps();
            
            $table->primary('id');
        });

        //Vinculo com questionario
        Schema::create('questionario_transtornos',  function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('questionario_id');
            $table->foreign('questionario_id', 'q_qt_q_fk')->references('id')->on('questionarios')->onDelete('cascade');

            $table->unsignedBigInteger('transtorno_id');
            $table->foreign('transtorno_id', 'q_qt_t_fk')->references('id')->on('transtornos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionario_transtornos');
        Schema::dropIfExists('transtornos');
    }
}
