<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardapioTurma extends Model
{
  
    /**
     * @var string
     */
    protected $table = 'modules.cardapio_turma';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'cod_escola',
        'cod_turma',
        'data',
        'turno',
        'cod_cardapio'
    
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    
    use HasFactory;

}
