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
                'id' => 6324,
                'parent_id' => 6323,
                'title' => 'Cadastro de Unidades',
                'description' => 'Cadastro de unidades de peso e medida',
                'link' => '/intranet/educar_unidade_lst.php',
                'icon' => NULL,
                'order' => 1,
                'type' => 4,
                'process' => 9211,
                'old' => 9853,
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
