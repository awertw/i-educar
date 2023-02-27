<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frequencia extends Model
{
    /**
     * @var string
     */
    protected $table = 'modules.frequencia';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'data',
        'ref_cod_turma',
        'ref_componente_curricular',
        'ordens_aulas',
        'etapa_sequencial'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;


    use HasFactory;

    public function studentAbsencesFrequency()
    {
        return $this->hasMany(FrequenciaAluno::class, 'ref_frequencia');
    }

}
