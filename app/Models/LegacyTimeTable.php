<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegacyTimeTable extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'pmieducar.quadro_horario';

    /**
     * @var string
     */
    protected $primaryKey = 'cod_quadro_horario';

    protected $fillable = [
        'ref_usuario_exec',
        'ref_usuario_cad',
        'ref_cod_turma',
        'ativo',
        'ano'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    public function horarys()
    {
        return $this->hasMany(QuadroHorarioHorarios::class, 'ref_cod_quadro_horario');
    }
}
