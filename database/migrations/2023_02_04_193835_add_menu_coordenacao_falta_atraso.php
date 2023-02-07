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
        DB::table('public.menus')->insert(
            [
                'id' => 3957,
                'parent_id' => 393,
                'title' => 'Cadastro Falta/Atraso Professor',
                'description' => 'Cadastro Falta/Atraso Professor',
                'link' => '/intranet/educar_coordenacao_falta_atraso_professor_lst.php',
                'icon' => NULL,
                'order' => 3,
                'type' => 2,
                'process' => 58,
                'old' => NULL,
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
