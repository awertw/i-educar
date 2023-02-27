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
   
    Schema::create('modules.cardapio_curso', function (Blueprint $table) {
        $table->text('cod_cardapio')->nullable();
        $table->text('cod_curso')->nullable();
    });
    
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules.cardapio_curso');
    }
};
