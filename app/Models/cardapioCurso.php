<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cardapioCurso extends Model
{
   
    /**
     * @var string
     */
    protected $table = 'modules.cardapio_curso';

    /**
     * @var string
     */
    protected $primaryKey = 'cod_cardapio';

    protected $fillable = [
        'cod_curso',
        'cod_cardapio'
    
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    
    use HasFactory;

   
}
