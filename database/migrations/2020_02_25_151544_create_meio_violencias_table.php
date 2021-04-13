<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeioViolenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meios_violencia', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->string('descricao');
            $table->timestamps();
            
            $table->primary('id');
        });

        //Vinculo com questionario
        Schema::create('questionario_meios_violencia',  function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('questionario_id');
            $table->foreign('questionario_id', 'q_qmv_q_fk')->references('id')->on('questionarios')->onDelete('cascade');

            $table->unsignedBigInteger('meio_violencia_id');
            $table->foreign('meio_violencia_id', 'q_qmv_m_fk')->references('id')->on('meios_violencia')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionario_meios_violencia');
        Schema::dropIfExists('meios_violencia');
    }
}
