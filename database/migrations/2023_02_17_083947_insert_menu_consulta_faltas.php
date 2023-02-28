<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertMenuConsultaFaltas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('public.menus')->insert(
            array(
                'id' => 399,
                'parent_id' => 81,
                'title' => 'Consulta de faltas',
                'description' => 'Consulta de faltas',
                'link' => '/intranet/educar_consulta_faltas.php',
                'icon' => NULL,
                'order' => 4,
                'type' => 4,
                'process' => 9998911,
                'old' => NULL,
                'parent_old' => NULL,
                'active' => true,
                'created_at' => NULL,
                'updated_at' => NULL
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
