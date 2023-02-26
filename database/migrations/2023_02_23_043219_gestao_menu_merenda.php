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
        DB::table('public.menus')->insert(
            [
                'id' => 6320,
                'parent_id' => 6317,
                'title' => 'Gestão',
                'description' => ' ',
                'link' => NULL,
                'icon' => NULL,
                'order' => 2,
                'type' => 2,
                'process' => NULL,
                'old' => 87221,
                'parent_old' => NULL,
                'active' => true,
                'created_at' => NULL,
                'updated_at' => NULL
            ]
        );

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
