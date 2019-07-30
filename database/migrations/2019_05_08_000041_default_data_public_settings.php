<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class DefaultDataPublicSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Artisan::call('db:seed', ['--class' => DefaultSettingsTableSeeder::class, '--force' => true]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::raw('TRUNCATE settings CASCADE;');
    }
}