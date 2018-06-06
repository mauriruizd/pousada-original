<?php

namespace App\Entities;

use App\Entities\Enumeration\TipoMovimento;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{
    protected $fillable = [
        'id',
        'valor',
        'motivo',
        'tipo',
        'id_caixa',
        'id_cargo_conta',
        'id_pagamento_conta'
    ];

    public function setValorAttribute($valor)
    {
        $this->attributes['valor'] = $valor;
        if (!empty($this->attributes['tipo']) && !empty($this->attributes['id_caixa'])) {
            $this->atualizarValorCaixa($this->attributes['tipo'], $this->attributes['valor']);
        }
    }

    public function setTipoAttribute($tipo)
    {
        $this->attributes['tipo'] = $tipo;
        if (!empty($this->attributes['valor']) && !empty($this->attributes['id_caixa'])) {
            $this->atualizarValorCaixa($this->attributes['tipo'], $this->attributes['valor']);
        }
    }

    public function setIdCaixaAttribute($idCaixa)
    {
        $this->attributes['id_caixa'] = $idCaixa;
        if (!empty($this->attributes['tipo']) && !empty($this->attributes['valor'])) {
            $this->atualizarValorCaixa($this->attributes['tipo'], $this->attributes['valor']);
        }
    }

    private function atualizarValorCaixa($tipo, $valor)
    {
        $caixa = $this->caixa;
        if ($tipo == TipoMovimento::$SAIDA) {
            $valor = $valor * -1;
        }
        $caixa->valor_total = $caixa->valor_total + $valor;
        $caixa->save();
    }

    public function getDataHoraLancamento()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d/m/Y H:i:s');
    }

    public function caixa()
    {
        return $this->belongsTo(Caixa::class, 'id_caixa', 'id');
    }
}
