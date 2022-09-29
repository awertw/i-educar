<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurmaSerieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pmieducar.turma_serie', function (Blueprint $table) {
            $table->id();
            $table->integer('escola_id');
            $table->integer('serie_id');
            $table->integer('turma_id');
            $table->integer('boletim_id');
            $table->integer('boletim_diferenciado_id')->nullable();
            $table->timestamps();
            $table->foreign('turma_id')
                ->references('cod_turma')
                ->on('pmieducar.turma');
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pmieducar.turma_serie');
    }
}
