<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PrecoProduto extends Model
{
    protected $table = 'precos_produtos';

    protected $fillable = [
        'id_produto',
        'preco',
        'datahora_cadastro'
    ];
}
