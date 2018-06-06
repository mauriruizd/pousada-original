<?php

namespace App\Entities;

use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SearchableEntity;
use App\Entities\Traits\DefaultSearchTrait;
use App\Entities\Traits\PrettyDateTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Sabberworm\CSS\Rule\Rule;

class Estada extends Model implements SearchableEntity, EntityValidation
{
    use DefaultSearchTrait;

    protected $fillable = [
        'id',
        'datahora_entrada',
        'datahora_saida',
        'nro_dias',
        'valor_total',
        'id_reserva',
        'id_usuario',
        'id_quarto'
    ];

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDatahoraEntrada()
    {
        return ;
    }

    /**
     * @param mixed $datahora_entrada
     */
    public function setDatahoraEntrada($datahora_entrada)
    {
        $this->datahora_entrada = $datahora_entrada;
    }

    /**
     * @return mixed
     */
    public function getDatahoraSaida()
    {
        return $this->datahora_saida;
    }

    /**
     * @param mixed $datahora_saida
     */
    public function setDatahoraSaida($datahora_saida)
    {
        $this->datahora_saida = $datahora_saida;
    }

    /**
     * @return mixed
     */
    public function getNroDias()
    {
        return $this->nro_dias;
    }

    /**
     * @param mixed $nro_dias
     */
    public function setNroDias($nro_dias)
    {
        $this->nro_dias = $nro_dias;
    }

    /**
     * @return mixed
     */
    public function getValorTotal()
    {
        return $this->valor_total;
    }

    /**
     * @param mixed $valor_total
     */
    public function setValorTotal($valor_total)
    {
        $this->valor_total = $valor_total;
    }

    /**
     * @return mixed
     */
    public function getIdReserva()
    {
        return $this->id_reserva;
    }

    /**
     * @param mixed $id_reserva
     */
    public function setIdReserva($id_reserva)
    {
        $this->id_reserva = $id_reserva;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    /**
     * @param mixed $id_usuario
     */
    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    /**
     * @return mixed
     */
    public function getIdQuarto()
    {
        return $this->id_quarto;
    }

    /**
     * @param mixed $id_quarto
     */
    public function setIdQuarto($id_quarto)
    {
        $this->id_quarto = $id_quarto;
    }

    public function scopeAberta($q)
    {
        return $q->where('datahora_saida', null);
    }

    public function getSaldo()
    {
        return $this->getTotalCargos() - $this->getTotalPago();
    }

    public function getTotalCargos()
    {
        return $this->cargos()->sum('valor') + $this->getReserva()->getValorTotal();
    }

    public function getTotalPago()
    {
        return $this->pagamentos()->sum('valor') + $this->getReserva()->getTotalPago();
    }

    public function cargos()
    {
        return $this->hasMany(CargoConta::class, 'id_estada', 'id');
    }

    public function getCargos()
    {
        return $this->cargos;
    }

    public function pagamentos()
    {
        return $this->hasMany(PagamentoConta::class, 'id_estada', 'id');
    }

    public function getPagamentos()
    {
        return $this->pagamentos;
    }

    public function hospedes()
    {
        return $this->hasMany(Hospede::class, 'id_estada', 'id');
    }

    public function getHospedes()
    {
        return $this->hospedes;
    }

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_reserva', 'id');
    }

    public function getReserva()
    {
        return $this->reserva;
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function quarto()
    {
        return $this->belongsTo(Quarto::class, 'id_quarto', 'id');
    }

    public function getQuarto()
    {
        return $this->quarto;
    }

    public function extenderEstada($diarias)
    {
        $this->setNroDias($this->getNroDias() + $diarias);
        $reserva = $this->getReserva();
        $reserva->setDataSaida(Carbon::createFromFormat('d/m/Y', $reserva->getDataSaida())->addDay($diarias)->format('Y-m-d'));
        $reserva->save();
    }

    public function getReservaProxima()
    {
        return Reserva::where('data_entrada', '>', Carbon::createFromFormat('d/m/Y', $this->getReserva()->getDataSaida()))
            ->where('id_quarto', '=', $this->getIdQuarto())
            ->orderBy('data_entrada', 'asc')
            ->first();
    }

    public function getReservaProximaDias()
    {
        $proxima = $this->getReservaProxima();
        return Carbon::createFromFormat('d/m/Y', $this->getReserva()->getDataSaida())->diffInDays(is_null($proxima) ? Carbon::now() : Carbon::createFromFormat('d/m/Y', $proxima->getDataEntrada()));
    }

    public static function validationRules(Request $request)
    {
        switch (true) {
            case strtolower($request->method()) === 'post' && str_contains($request->path(), 'checkin'):
                return [
                    'hospedes' => 'required'
                ];
            case str_contains($request, 'registrar-dano'):
                return [
                    'valor' => 'required|numeric',
                    'descricao' => 'required'
                ];
            case str_contains($request, 'registrar-pagamento'):
                return [
                    'id_quarto' => 'required',
                    'quantia' => 'required|max:' . Estada::find($request->route('estada'))->getSaldo()
                ];
            case strtolower($request->method()) === 'post' && str_contains($request, 'frigobar'):
                return [
                    'id_produto' => 'required|exists:produtos,id',
                    'quantidade' => 'required|numeric|max:' . Produto::find($request->id_produto)->getEstoque()
                ];
            case str_contains($request, 'hospedes'):
                return [
                    'hospedes' => 'required'
                ];
            case str_contains($request, 'adicionar-diarias'):
                return [];
            default:
                return [];
        }
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function (Estada $model) {
            if (!empty($model->getReserva()->getTotalComissaoFonte())) {
                auth()->user()->caixaAberto()->registrarSaque($model->getReserva()->getTotalComissaoFonte(), 'PAGAMENTO DE COMISSÃO ' . strtoupper($model->getReserva()->fonte->getNome()) . ' POR RESERVA #' . $model->getIdReserva());
            }
        });
    }

    public static function authorizationVerification(Request $request)
    {
        return true;
    }

    public static function searchableFields()
    {
        return [
            'id',
            'id_reserva',
            'datahora_entrada',
            'datahora_saida'
        ];
    }


}
