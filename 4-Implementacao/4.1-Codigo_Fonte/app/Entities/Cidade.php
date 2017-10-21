<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $fillable = [
        'id',
        'nome',
        'id_estado'
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

    public function getEstado()
    {
        return $this->estado;
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id');
    }


}
