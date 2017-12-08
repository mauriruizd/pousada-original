<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Hospede extends Model
{
    protected $fillable = [
        'id_estada',
        'id_cliente'
    ];

    public function estada()
    {
        return $this->belongsTo(Estada::class, 'id_estada', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id');
    }
}
