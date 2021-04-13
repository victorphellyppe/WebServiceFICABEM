<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoViolenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_violencia', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();;
            $table->string('descricao');
            $table->timestamps();
            
            $table->primary('id');
        });

        //Vinculo com questionario
        Schema::create('questionario_tipos_violencia',  function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('questionario_id');
            $table->foreign('questionario_id', 'q_qtv_q_fk')->references('id')->on('questionarios')->onDelete('cascade');

            $table->unsignedBigInteger('tipo_violencia_id');
            $table->foreign('tipo_violencia_id', 'q_qtv_v_fk')->references('id')->on('tipos_violencia')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionario_tipos_violencia');
        Schema::dropIfExists('tipos_violencia');
    }
}
