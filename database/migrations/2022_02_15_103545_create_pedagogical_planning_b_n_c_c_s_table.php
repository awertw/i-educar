<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedagogicalPlanningBNCCSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules.planejamento_pedagogico_bncc', function (Blueprint $table) {
            $table->id();
            $table->integer('planejamento_pedagogico_id');
            $table->integer('bncc_id');
            
            $table->foreign('planejamento_pedagogico_id')
                ->references('id')
                ->on('modules.planejamento_pedagogico')
                ->onDelete('cascade');

            $table->foreign('bncc_id')
                ->references('id')
                ->on('modules.bncc')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules.planejamento_pedagogico_bncc');
    }
}