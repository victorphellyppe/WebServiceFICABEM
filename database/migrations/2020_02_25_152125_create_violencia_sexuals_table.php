<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViolenciaSexualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('violencias_sexuais', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->string('descricao');
            $table->timestamps();
            
            $table->primary('id');
        });

        //Vinculo com questionario
        Schema::create('questionario_violencias_sexuais',  function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('questionario_id');
            $table->foreign('questionario_id', 'q_qvs_q_fk')->references('id')->on('questionarios')->onDelete('cascade');

            $table->unsignedBigInteger('violencia_sexual_id');
            $table->foreign('violencia_sexual_id', 'q_qvs_v_fk')->references('id')->on('violencias_sexuais')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionario_violencias_sexuais');
        Schema::dropIfExists('violencias_sexuais');
    }
}
