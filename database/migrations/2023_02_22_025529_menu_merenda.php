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
                'id' => 6317,
                'parent_id' => NULL,
                'title' => 'Merenda Escolar',
                'description' => ' ',
                'link' => '/intranet/educar_merenda_escolar_index.php.php',
                'icon' => 'fa-cutlery',
                'order' => 8,
                'type' => 1,
                'process' => 9204,
                'old' => 9204,
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
