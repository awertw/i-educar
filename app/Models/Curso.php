<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{

    /**
     * @var string
     */
    protected $table = 'pmieducar.curso';

    /**
     * @var string
     */
    protected $primaryKey = 'cod_curso';

    protected $fillable = [
        'cod_curso',
        'nm_curso'
       
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
 
    
    use HasFactory;



}
