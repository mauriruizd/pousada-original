<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $fillable = [
        'id',
        'nome',
        'id_pais'
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'id_pais', 'id');
    }

    public function cidades()
    {
        return $this->hasMany(Cidade::class, 'id_estado', 'id');
    }
}
