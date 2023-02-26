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
        Schema::table('pmieducar.instituicao', function (Blueprint $table) {
            DB::statement('ALTER TABLE pmieducar.instituicao ALTER COLUMN responsavel_contabil TYPE integer USING (responsavel_contabil)::integer');
            DB::statement('ALTER TABLE pmieducar.instituicao ALTER COLUMN gestor TYPE integer USING (gestor)::integer');
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
            $table->string('responsavel_contabil')->nullable()->change();
            $table->string('gestor')->nullable()->change();
        });
    }
};
