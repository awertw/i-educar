<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurmaTurno extends Model
{
    
    /**
     * @var string
     */
    protected $table = 'pmieducar.turma_turno';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nome',
        'ativo'
        
    
    ]; 

    /**
     * @var bool
     */
    public $timestamps = false;

    
    use HasFactory;
}
