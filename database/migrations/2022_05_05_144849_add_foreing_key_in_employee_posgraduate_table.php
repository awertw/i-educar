<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_posgraduate', function (Blueprint $table) {
            $table->foreign(['employee_id'])
                ->on('pmieducar.servidor')
                ->references(['cod_servidor']);
                $table->foreign(['entity_id'])
                ->on('pmieducar.servidor')
                ->references(['ref_cod_instituicao']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_posgraduate', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->dropForeign(['entity_id']);
        });
    }
};
