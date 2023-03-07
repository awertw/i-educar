<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules.cardapio_turma', function (Blueprint $table) {
            $table->id();
            $table->text('cod_escola')->nullable();
            $table->text('cod_turma')->nullable();
            $table->date('data')->nullable();
            $table->text('turno')->nullable();
            $table->text('cod_cardapio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules.cardapio_turma');
    }
};
