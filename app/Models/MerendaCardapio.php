<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerendaCardapio extends Model
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
        
        'id',
        'descricao',
        'dia_semana',
        'preparo'
        
    
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    
    use HasFactory;


}
