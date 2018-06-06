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

    protected static function boot()
    {
        parent::boot();
        static::created(function (PagamentoConta $model) {
            auth()->user()->caixaAberto()->registrarPagamento($model->valor, 'PAGAMENTO DE CONTA DE RESERVA #' . $model->estada()->getIdReserva());
        });
    }
}
