<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            //=============== AUTOR ==================//
            $table->unsignedBigInteger('autor_id')->nullable();
            $table->foreign('autor_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->boolean('anonimo')->default(false);
            $table->boolean('atendido')->default(false);
            $table->integer('denuncia')->default(7)->comment(' 1 - Conselheiro tutelar | 2 - Profissional da saude  | 3 - Profissional da segurança pública | 4 - Profissional da educação | 5 - População | 9 - Ignorado');
            //Alteracao Victor

            //=========== Dados da Vitima =============//
            //NOVO!!!
            $table->string('nome')->default('Não informado')->nullable();
            $table->string('telefone')->default('Não informado')->nullable();
            $table->string('endereco')->default('Não informado')->nullable();
            $table->string('cpf')->default('Não informado')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->enum('genero', ['feminino','masculino','ignorado'])->default('ignorado');
            $table->integer('raca')->default(9)->comment('1 - Branca | 2 - Preta | 3 - Amarela | 4 - Parda | 5 Indigena | 9 - Ignorado');


            $table->boolean('drogas_familia');
            $table->string('usuario_droga_familia')->nullable();
            $table->boolean('tem_beneficio');
            $table->string('beneficio')->nullable();
            $table->boolean('denunciado');
            $table->boolean('abuso_anterior');
            $table->string('abusador_anterior')->nullable();
            $table->integer('gestante');
            $table->integer('escolaridade');
            $table->integer('zona');
            $table->integer('estado_civil');
            $table->integer('orientacao_sexual');
            $table->integer('identidade_genero');
            $table->boolean('tem_transtorno');
            // ============== Dados da ocorrência ============//
            $table->date('dia_ocorrencia')->nullable();
            $table->time('hora_ocorrencia')->nullable();
            $table->integer('ocorreu_outras_vezes');
            $table->integer('lesao_autoprovocada');
            // ============== Violencia =====================//
            $table->integer('motivo_violencia');
            $table->integer('violencia_trabalho');
            // ============= Autor da violência ============= //
            $table->integer('numero_envolvidos');
            $table->integer('sexo_agressor');
            $table->integer('uso_alcool'); 
            $table->integer('idade_agressor');
            $table->string('observacao')->nullable();


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
        Schema::dropIfExists('questionarios');
    }
}
