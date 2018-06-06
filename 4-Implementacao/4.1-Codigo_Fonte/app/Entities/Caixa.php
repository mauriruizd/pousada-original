<?php

namespace App\Entities;

use App\Entities\Enumeration\TipoMovimento;
use App\Entities\Interfaces\EntityValidation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Caixa extends Model implements
    EntityValidation
{
    protected $fillable = [
        'id',
        'quantidade_inicial',
        'datahora_apertura',
        'datahora_fechamento',
        'valor_total',
        'id_usuario'
    ];

    public function registrarPagamento($valor, $motivo)
    {
        Movimento::create([
            'valor' => $valor,
            'motivo' => $motivo,
            'tipo' => TipoMovimento::$ENTRADA,
            'id_caixa' => $this->id,
        ]);
    }

    public function registrarSaque($valor, $motivo)
    {
        Movimento::create([
            'valor' => $valor,
            'motivo' => $motivo,
            'tipo' => TipoMovimento::$SAIDA,
            'id_caixa' => $this->id,
        ]);
    }

    public function registrarDeposito($valor, $motivo)
    {
        Movimento::create([
            'valor' => $valor,
            'motivo' => $motivo,
            'tipo' => TipoMovimento::$ENTRADA,
            'id_caixa' => $this->id,
        ]);
    }

    public function getDataHoraApertura()
    {
        return $this->formatDataHora($this->datahora_apertura);
    }

    public function getDataHoraFechamento()
    {
        return $this->formatDataHora($this->datahora_fechamento);
    }

    private function formatDataHora($dataHora)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $dataHora)->format('d/m/Y H:i:s');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }

    public function movimentos()
    {
        return $this->hasMany(Movimento::class, 'id_caixa', 'id');
    }

    public function scopeDoUsuario($q, $id)
    {
        return $q->where('id_usuario', $id);
    }

    public function scopeAberto($q)
    {
        return $q->where('datahora_fechamento', null);
    }

    public static function validationRules(Request $request)
    {
        if (strtolower($request->method()) == 'post' && str_contains($request->path(), 'abrir')) {
            return [
                'quantidade_inicial' => 'required'
            ];
        }
        return [];
    }

    public static function authorizationVerification(Request $request)
    {
        return true;
    }

}
