<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    
    /**
     * @var string
     */
    protected $table = 'modules.unidade';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'unidade',
        'descricao',
        
    
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    
    use HasFactory;

  
}
