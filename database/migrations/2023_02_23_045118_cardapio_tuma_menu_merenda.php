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
                'id' => 6322,
                'parent_id' => 6320,
                'title' => 'Cardápio das turmas',
                'description' => 'Cadastro de cardápios em turmas',
                'link' => '/intranet/educar_cardapio_turma_lst.php',
                'icon' => NULL,
                'order' => 2,
                'type' => 3,
                'process' => 9208,
                'old' => 687314,
                'parent_old' => NULL,
                'active' => true,
                'created_at' => NULL,
                'updated_at' => NULL
            ]
        );    }

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
