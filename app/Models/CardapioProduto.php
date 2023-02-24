<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardapioProduto extends Model
{
     

    /**
     * @var string
     */
    protected $table = 'modules.cardapio_produto';

    /**
     * @var string
     */
    protected $primaryKey = 'cod_cardapio';

    protected $fillable = [
        
        'cod_produto',
        'cod_cardapio'
        
    
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    
    use HasFactory;


}
