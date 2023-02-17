<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCodUnidadeGestoraOnIntituicao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pmieducar.instituicao', function (Blueprint $table) {
            $table->string('cod_unidade_gestora')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pmieducar.instituicao', function (Blueprint $table) {
            $table->dropColumn('cod_unidade_gestora');
        });
    }
}
