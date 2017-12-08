<?php

namespace App\Entities;

use App\Entities\Estada;
use Illuminate\Database\Eloquent\Model;

class PagamentoConta extends Model
{
    protected $fillable = [
        'id_estada',
        'id_usuario',
        'valor'
    ];

    public function estada()
    {
        return $this->belongsTo(Estada::class, 'id_estada', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }
}
