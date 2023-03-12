<?php

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up()
    {
        
    }

    public function createOrUpdate($state_abbreviation, $name, $ibge_code, $old_name = null)
    {
       
    }

    public function down()
    {
    }
};
