<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriandoTabelaMotivoNaoDenunciar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motivo_nao_denunciar', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->string('descricao');
            $table->timestamps();
            
            $table->primary('id');
        });

        //Vinculo com questionario
        Schema::create('questionario_motivo_nao_denunciar',  function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('questionario_id');
            $table->foreign('questionario_id', 'q_mnd_q_fk')->references('id')->on('questionarios')->onDelete('cascade');

            $table->unsignedBigInteger('motivo_nao_denunciar_id');
            $table->foreign('motivo_nao_denunciar_id', 'q_mnd_m_fk')->references('id')->on('motivo_nao_denunciar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionario_motivo_nao_denunciar');
        Schema::dropIfExists('motivo_nao_denunciar');
    }
}
