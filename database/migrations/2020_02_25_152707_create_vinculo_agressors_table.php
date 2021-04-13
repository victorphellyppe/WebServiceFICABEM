<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVinculoAgressorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vinculo_agressores', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->string('descricao');
            $table->timestamps();
            
            $table->primary('id');
        });

        //Vinculo com questionario
        Schema::create('questionario_vinculo_agressores',  function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('questionario_id');
            $table->foreign('questionario_id', 'q_va_q_fk')->references('id')->on('questionarios')->onDelete('cascade');

            $table->unsignedBigInteger('vinculo_agressor_id');
            $table->foreign('vinculo_agressor_id', 'q_va_va_fk')->references('id')->on('vinculo_agressores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionario_vinculo_agressores');
        Schema::dropIfExists('vinculo_agressores');
    }
}
