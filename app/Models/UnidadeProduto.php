<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadeProduto extends Model
{
     
    /**
     * @var string
     */
    protected $table = 'modules.unidade_produto';

    /**
     * @var string
     */
    protected $primaryKey = 'cod_produto';

    protected $fillable = [
        
        'cod_produto',
        'cod_unidade'
        
    
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    
    use HasFactory;

}
