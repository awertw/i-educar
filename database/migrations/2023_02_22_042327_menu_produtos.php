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
                'id' => 6319,
                'parent_id' => 6318,
                'title' => 'Produtos',
                'description' => 'Cadastro de produtos',
                'link' => '/intranet/educar_produto_lst.php',
                'icon' => NULL,
                'order' => 1,
                'type' => 3,
                'process' => 9205,
                'old' => 1548175,
                'parent_old' => NULL,
                'active' => true,
                'created_at' => NULL,
                'updated_at' => NULL
            ]
        );
        //
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
