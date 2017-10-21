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

    public function getPais()
    {
        return $this->pais;
    }

    public function getCidades()
    {
        return $this->cidades;
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'id_pais', 'id');
    }

    public function cidades()
    {
        return $this->hasMany(Cidade::class, 'id_estado', 'id');
    }
}
