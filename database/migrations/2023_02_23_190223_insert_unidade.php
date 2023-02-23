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
        DB::table('modules.unidade')->insert(
            array(
                [
                    'id' => 1,
                    'unidade' => 'BALDE',
                    'descricao' => 'BALDE',
                ],
                [
                    'id' => 2,
                    'unidade' => 'BARRA',
                    'descricao' => 'BARRA',
                ],
                [
                    'id' => 3,
                    'unidade' => 'BISNAGA',
                    'descricao' => 'BISNAGA',
                ],
                [
                    'id' => 4,
                    'unidade' => 'BLOCO',
                    'descricao' => 'BLOCO',
                ],
                [
                    'id' => 5,
                    'unidade' => 'BOBINA',
                    'descricao' => 'BOBINA',
                ],
                [
                    'id' => 6,
                    'unidade' => 'CAPS',
                    'descricao' => 'CAPSULA',
                ],
                [
                    'id' => 7,
                    'unidade' => 'CART',
                    'descricao' => 'CARTELA',
                ],
                [
                    'id' => 8,
                    'unidade' => 'CJ',
                    'descricao' => 'CONJUNTO',
                ],
                [
                    'id' => 9,
                    'unidade' => 'CM',
                    'descricao' => 'CENTIMETRO',
                ],
                [
                    'id' => 10,
                    'unidade' => 'CX',
                    'descricao' => 'CAIXA',
                ],
                [
                    'id' => 11,
                    'unidade' => 'EMBAL',
                    'descricao' => 'EMBALAGEM',
                ],
                [
                    'id' => 12,
                    'unidade' => 'FARDO',
                    'descricao' => 'FARDO',
                ],
                [
                    'id' => 13,
                    'unidade' => 'FOLHA',
                    'descricao' => 'FOLHA',
                ],
                [
                    'id' => 14,
                    'unidade' => 'FRASCO',
                    'descricao' => 'FRASCO',
                ],
                [
                    'id' => 15,
                    'unidade' => 'GALAO',
                    'descricao' => 'GALAO',
                ],
                [
                    'id' => 16,
                    'unidade' => 'GF',
                    'descricao' => 'GARRAFA',
                ],
                [
                    'id' => 17,
                    'unidade' => 'GRAMAS',
                    'descricao' => 'GRAMAS',
                ],
                [
                    'id' => 18,
                    'unidade' => 'KG',
                    'descricao' => 'QUILOGRAMA',
                ],
                [
                    'id' => 19,
                    'unidade' => 'KIT',
                    'descricao' => 'KIT',
                ],
                [
                    'id' => 20,
                    'unidade' => 'LATA',
                    'descricao' => 'LATA',
                ],
                [
                    'id' => 21,
                    'unidade' => 'LITRO',
                    'descricao' => 'LITRO',
                ],
                [
                    'id' => 22,
                    'unidade' => 'M',
                    'descricao' => 'METRO',
                ],
                [
                    'id' => 23,
                    'unidade' => 'PACOTE',
                    'descricao' => 'PACOTE',
                ],
                [
                    'id' => 24,
                    'unidade' => 'PALETE',
                    'descricao' => 'PALETE',
                ],
                [
                    'id' => 25,
                    'unidade' => 'PC',
                    'descricao' => 'PEÇA',
                ],
                [
                    'id' => 26,
                    'unidade' => 'POTE',
                    'descricao' => 'POTE',
                ],
                [
                    'id' => 27,
                    'unidade' => 'ROLO',
                    'descricao' => 'ROLO',
                ],
                [
                    'id' => 28,
                    'unidade' => 'SACO',
                    'descricao' => 'SACO',
                ],
                [
                    'id' => 29,
                    'unidade' => 'SACOLA',
                    'descricao' => 'SACOLA',
                ],
                [
                    'id' => 30,
                    'unidade' => 'TAMBOR',
                    'descricao' => 'TAMBOR',
                ],
                [
                    'id' => 31,
                    'unidade' => 'TANQUE',
                    'descricao' => 'TANQUE',
                ],

                [
                    'id' => 32,
                    'unidade' => 'TON',
                    'descricao' => 'TONELADA',
                ],
                [
                    'id' => 33,
                    'unidade' => 'TUBO',
                    'descricao' => 'TUBO',
                ],
                [
                    'id' => 34,
                    'unidade' => 'UNID',
                    'descricao' => 'UNIDADE',
                ],
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
        //
    }
};
