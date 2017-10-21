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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    public function getEstados()
    {
        return $this->estados;
    }

    public function estados()
    {
        return $this->hasMany(Estado::class, 'id_pais', 'id');
    }
}
