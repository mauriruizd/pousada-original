<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'paises';

    protected $fillable = [
        'id',
        'nome'
    ];

    public function estados()
    {
        return $this->hasMany(Estado::class, 'id_pais', 'id');
    }
}
