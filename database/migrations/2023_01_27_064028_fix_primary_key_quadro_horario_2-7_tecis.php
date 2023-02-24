<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        //MIGRATION CRIADA PARA CORRIGIR A CHAVE PRIMARIA DESSA TABELA
        //EM ALGUM MOMENTO (NÃO SABEMOS QUANDO E O MOTIVO) DA UTILIZAÇÃO DA V.2.6-TECSIS ESSES CAMPOS PERDERAM A CHAVE PRIMARIA
        //COMO A FEATURE DA COORDERNAÇÃO FOI DESENVOLVIDA ADICIONANDO ESSA CHAVE PRIMARIA (PENSAMOS NÃO EXISTIR PARA ESSA TABELA)
        //NÃO PODEMOS USAR A DA V.2-7
       DB::unprepared(
           'ALTER TABLE ONLY pmieducar.quadro_horario_horarios
                    DROP CONSTRAINT quadro_horario_horarios_pkey;'
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
