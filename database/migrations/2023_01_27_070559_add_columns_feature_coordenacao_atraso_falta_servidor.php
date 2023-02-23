<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('pmieducar.quadro_horario_horarios', function (Blueprint $table) {
            $table->increments('ref_cod_quadro_horario_horarios');
        });

        Schema::table('pmieducar.falta_atraso', function (Blueprint $table) {
            $table->unsignedBigInteger('ref_cod_curso')->nullable();
            $table->unsignedBigInteger('ref_cod_serie')->nullable();
            $table->unsignedBigInteger('ref_cod_turma')->nullable();
            $table->unsignedBigInteger('ref_cod_componente_curricular')->nullable();
            $table->text('observacao')->nullable();
            $table->integer('ano')->nullable();
            $table->integer('qtd_aulas')->default(0);
        });

        Schema::create('pmieducar.falta_atraso_horarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ref_cod_falta_atraso');
            $table->unsignedBigInteger('ref_cod_quadro_horario_horarios');
            $table->string('aulas')->default('1')->nullable();
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
        //
    }
};
