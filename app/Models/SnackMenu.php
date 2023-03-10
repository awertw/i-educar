<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnackMenu extends Model
{

    /**
     * @var string
     */
    protected $table = 'modules.merenda_cardapio';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'descricao',
        'preparo',
        'dia_semana',
        'cod_turno',
        'inativo',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;


    use HasFactory;
}
