<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DefaultDataCadastroOrgaoEmissorRg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Artisan::call('db:seed', ['--class' => DefaultCadastroOrgaoEmissorRgTableSeeder::class, '--force' => true]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::raw('TRUNCATE cadastro.orgao_emissor_rg CASCADE;');
    }
}
