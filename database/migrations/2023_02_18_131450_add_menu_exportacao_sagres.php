<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('public.menus')->insert(
            [
                'id' => 3958,
                'parent_id' => 233,
                'title' => 'Exportação para o Sagres',
                'description' => 'Exportação para o Sagres',
                'link' => '/exportacao-sagres',
                'icon' => NULL,
                'order' => 100,
                'type' => 1,
                'process' => 4000,
                'old' => NULL,
                'parent_old' => NULL,
                'active' => true,
                'created_at' => NULL,
                'updated_at' => NULL
            ]
        );
    }
};
