<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuadroHorarioHorarios extends Model
{

    /**
     * @var string
     */
    protected $table = 'pmieducar.quadro_horario_horarios';

    /**
     * @var string
     */
    protected $primaryKey = 'ref_cod_quadro_horario';

    protected $fillable = [
        'ref_cod_disciplina',
        'ref_cod_serie',
        'ref_servidor',
        'ref_cod_servidor_substituto_1',
        'ref_cod_servidor_substituto_2',
        'ativo'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;


    use HasFactory;


    public function employee()
    {
        return $this->hasOne(Employee::class, 'cod_servidor', 'ref_servidor');
    }

    public function employeeSubstitutoOne()
    {
        return $this->hasOne(Employee::class, 'cod_servidor', 'ref_cod_servidor_substituto_1');
    }

    public function employeeSubstitutoTwo()
    {
        return $this->hasOne(Employee::class, 'cod_servidor', 'ref_cod_servidor_substituto_2');
    }

    public function curricularComponent()
    {
        return $this->hasOne(LegacyCurricularComponent::class, 'id', 'ref_cod_disciplina');
    }

    public function timeTable()
    {
        return $this->belongsTo(LegacyTimeTable::class, 'ref_cod_quadro_horario');
    }
}
