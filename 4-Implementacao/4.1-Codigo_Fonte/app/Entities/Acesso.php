<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Acesso extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'timestamp',
        'ip'
    ];

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    public function getTimestampAttribute($val)
    {
        return Carbon::parse($val)->format('d/m/Y H:i:s');
    }
}
