<?php

use App\Support\Database\DropPrimaryKey;
use App\Support\Database\PrimaryKey;
use Illuminate\Database\Migrations\Migration;

class UpdateConstaintServidorDisciplina extends Migration
{
    use DropPrimaryKey;
    use PrimaryKey;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {}
}
