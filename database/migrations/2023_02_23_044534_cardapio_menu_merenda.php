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
                'id' => 6321,
                'parent_id' => 6320,
                'title' => 'Montar Cardápio',
                'description' => 'Cadastro de cardápios',
                'link' => '/intranet/educar_cardapio_lst.php',
                'icon' => NULL,
                'order' => 1,
                'type' => 3,
                'process' => 9207,
                'old' => 68734,
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
