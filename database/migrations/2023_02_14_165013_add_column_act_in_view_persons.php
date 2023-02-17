<?php

use App\Support\Database\MigrationUtils;
use Illuminate\Database\Migrations\Migration;

class AddColumnActInViewPersons extends Migration
{
    use MigrationUtils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $this->executeSqlFile(
            __DIR__ . '/../sqls/views/persons-14-02-2023.sql'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropView('persons-14-02-2023');

        $this->executeSqlFile(
            __DIR__ . '/../sqls/views/persons.sql'
        );
    }
}
