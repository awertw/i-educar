<<<<<<< HEAD
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRelatorioViewComponenteCurricularView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(
            'DROP VIEW IF EXISTS relatorio.view_componente_curricular;'
        );

        DB::unprepared(
            file_get_contents(__DIR__ . '/../../sqls/views/relatorio.view_componente_curricular.sql')
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared(
            'DROP VIEW IF EXISTS relatorio.view_componente_curricular;'
        );
    }
}
=======
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRelatorioViewComponenteCurricularView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(
            'DROP VIEW IF EXISTS relatorio.view_componente_curricular;'
        );

        DB::unprepared(
            file_get_contents(__DIR__ . '/../../sqls/views/relatorio.view_componente_curricular-2019-06-29.sql')
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared(
            'DROP VIEW IF EXISTS relatorio.view_componente_curricular;'
        );
    }
}
>>>>>>> 0e43d46bd70bbf8f4ae92c2780080d51c6ccd837
