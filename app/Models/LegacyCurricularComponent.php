<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegacyCurricularComponent extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'modules.componente_curricular';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'abreviatura',
        'tipo_base',
        'codigo_educacenso',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
