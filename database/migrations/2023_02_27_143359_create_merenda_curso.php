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

    Schema::table('modules.cardapio_curso', function($table) {
        $table->text('cod_curso')->nullable();
        $table->text('cod_cardapio')->nullable();
    });   
    
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merenda_curso');
    }
};
