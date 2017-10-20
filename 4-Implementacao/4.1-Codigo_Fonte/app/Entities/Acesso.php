<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Acesso extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'timestamp'
    ];
}
