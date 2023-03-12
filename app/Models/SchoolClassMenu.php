<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClassMenu extends Model
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
        'cod_escola',
        'cod_turma',
        'data',
        'turno',
        'cord_cardapio',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;


    use HasFactory;


    public function snackMenu()
    {
        return $this->hasOne(SnackMenu::class, 'id', 'cod_cardapio');
    }
}
