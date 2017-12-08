<?php

namespace App\Entities;

use App\Entities\Enumeration\EstadoReserva;
use App\Entities\Enumeration\MetodoPagamento;
use App\Entities\Enumeration\TipoUsuario;
use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SearchableEntity;
use App\Entities\Traits\DefaultSearchTrait;
use App\Entities\Traits\PrettyDateTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Reserva extends Model implements EntityValidation, SearchableEntity
{
    use SoftDeletes,
        DefaultSearchTrait,
        PrettyDateTrait;

    protected $fillable = [
        'id_quarto',
        'id_usuario',
        'data_entrada',
        'data_saida',
        'valor_total',
        'id_fonte',
        'id_comissionista',
        'total_comissao',
        'total_comissao_fonte',
        'total_devolvido_cancelamento',
        'comissao_paga',
        'id_cliente_reservante',
        'tipo_pagamento',
        'estado'
    ];

    public $total_devolvido_cancelamento;
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
    public function getDataEntrada()
    {
        return $this->data_entrada;
    }

    /**
     * @param mixed $data_entrada
     */
    public function setDataEntrada($data_entrada)
    {
        $this->data_entrada = $data_entrada;
    }

    /**
     * @return mixed
     */
    public function getDataSaida()
    {
        return $this->data_saida;
    }

    /**
     * @param mixed $data_saida
     */
    public function setDataSaida($data_saida)
    {
        $this->data_saida = $data_saida;
    }

    public function getDataEntradaAttribute($date)
    {
        return $this->getDate($date);
    }

    public function setDataEntradaAttribute($dateString)
    {
        $this->setDate($dateString, 'data_entrada');
        if (
            !empty($this->attributes['data_saida']) && strlen($this->attributes['data_saida']) !== 10
            &&
            !empty($this->attributes['id_quarto'])) {
            $this->setValorTotalFromDias($this->attributes['data_entrada'], $this->attributes['data_saida']);
        }
    }

    public function getDataSaidaAttribute($date)
    {
        return $this->getDate($date);
    }

    public function setDataSaidaAttribute($dateString)
    {
        $this->setDate($dateString, 'data_saida');
        if (
            !empty($this->attributes['data_entrada']) && strlen($this->attributes['data_entrada']) !== 10
            &&
            !empty($this->attributes['id_quarto'])) {
            $this->setValorTotalFromDias($this->attributes['data_entrada'], $this->attributes['data_saida']);
        }
    }

    private function setValorTotalFromDias($dataEntrada, $dataSaida)
    {

        $tipoQuarto = Quarto::find($this->attributes['id_quarto'])->getTipoQuarto();
        $excecoes = ExcecaoPreco::where('id_tipo_quarto', $tipoQuarto->getId())
            ->where(function ($q) use ($dataEntrada, $dataSaida) {
                $q
                    ->where(function ($q) use ($dataEntrada) {
                        $q->whereDate('data_inicio', '<=', $dataEntrada)
                            ->whereDate('data_fim', '>=', $dataEntrada);
                    })
                    ->orWhere(function ($q) use ($dataSaida) {
                        $q->whereDate('data_inicio', '<=', $dataSaida)
                            ->whereDate('data_fim', '>=', $dataSaida);
                    })
                    ->orWhere(function ($q) use ($dataEntrada, $dataSaida) {
                        $q->whereDate('data_inicio', '>=', $dataEntrada)
                            ->whereDate('data_fim', '<=', $dataSaida);
                    });
            })
            ->get();
        $total = 0;
        $carbonData = Carbon::createFromFormat('Y-m-d H:i:s', $dataEntrada);
        $carbonSaida = Carbon::createFromFormat('Y-m-d H:i:s', $dataSaida);
        do {
            $isBetween = false;
            foreach ($excecoes as $excecao) {
                if (
                $carbonData->between(
                    Carbon::createFromFormat('Y-m-d H:i:s', $this->prettyDateToDBDate($excecao->getDataInicio())),
                    Carbon::createFromFormat('Y-m-d H:i:s', $this->prettyDateToDBDate($excecao->getDataFim()))
                )
                ) {
                    $total += $excecao->getPreco();
                    $isBetween = true;
                    break 1;
                }
            }
            if (!$isBetween) {
                $total += $tipoQuarto->getPreco();
            }
            $carbonData->addDay();
        } while (!$carbonData->isSameDay($carbonSaida));
        $this->attributes['valor_total'] = $total;
        $this->checkEstadoReserva(0);
        if (!empty($this->attributes['id_comissionista'])) {
            $this->calcularComissao($total, $this->attributes['id_comissionista']);
        }
        $this->setTotalComissaoFonte($this->getIdFonte(), $this->getTipoPagamento(), $this->getValorTotal());
    }

    private function calcularComissao($valorTotal, $idComissionista)
    {
        $this->attributes['total_comissao'] = Comissionista::find($idComissionista)
            ->calcularComissao($valorTotal);
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
    public function getTotalComissao()
    {
        return $this->total_comissao;
    }

    /**
     * @param mixed $total_comissao
     */
    public function setTotalComissao($total_comissao)
    {
        $this->total_comissao = $total_comissao;
    }

    /**
     * @return mixed
     */
    public function getTotalDevolvidoCancelamento()
    {
        return $this->total_devolvido_cancelamento;
    }

    /**
     * @param mixed $total_devolvido_cancelamento
     */
    public function setTotalDevolvidoCancelamento($total_devolvido_cancelamento)
    {
        $this->attributes['total_devolvido_cancelamento'] = $total_devolvido_cancelamento;
    }

    /**
     * @return mixed
     */
    public function getIdFonte()
    {
        return $this->id_fonte;
    }

    /**
     * @param mixed $id_fonte
     */
    public function setIdFonte($id_fonte)
    {
        $this->id_fonte = $id_fonte;
    }

    public function setIdFonteAttribute($idFonte)
    {
        $this->attributes['id_fonte'] = $idFonte;
        $this->setTotalComissaoFonte($this->getIdFonte(), $this->getTipoPagamento(), $this->getValorTotal());
    }

    /**
     * @return mixed
     */
    public function getComissaoPaga()
    {
        return $this->comissao_paga;
    }

    /**
     * @param mixed $comissao_paga
     */
    public function setComissaoPaga($comissao_paga)
    {
        $this->comissao_paga = $comissao_paga;
    }

    /**
     * @return mixed
     */
    public function getIdClienteReservante()
    {
        return $this->id_cliente_reservante;
    }

    /**
     * @param mixed $id_cliente_reservante
     */
    public function setIdClienteReservante($id_cliente_reservante)
    {
        $this->id_cliente_reservante = $id_cliente_reservante;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->attributes['estado'] = $estado;
        if ($this->estado == EstadoReserva::$CANCELADA) {
            $dataEntrada = Carbon::createFromFormat('d/m/Y', $this->getDataEntrada());
            $now = Carbon::now()->setTime(0,0,0);
            if ($dataEntrada->greaterThan($now)) {
                // dataEntrada > now, ainda nao e o dia de entrada
                $difDias = $dataEntrada->diffInDays($now);
                if ($difDias >= 7) {
                    // antes dos 7 dias da entrada
                    // Cancelamento gratis
                    $this->setTotalDevolvidoCancelamento($this->getValorTotal());
                } else {
                    // Dentro dos 7 dias
                    if (Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->setTime(0,0,0)->diffInDays($dataEntrada) < 3) {
                        // Cancelamento dentro das 48 hs. Cancelamento gratis
                        $this->setTotalDevolvidoCancelamento($this->getValorTotal());
                    } else {
                        // Cobrado 50%
                        $this->setTotalDevolvidoCancelamento($this->getValorTotal() / 2);
                    }
                }
            } elseif ($dataEntrada->isSameDay($now)) {
                // Mesmo dia. Cobrado 100%
                $this->setTotalDevolvidoCancelamento(0);
            }
            $this->setTotalComissaoFonte($this->getIdFonte(), $this->getTipoPagamento(), 0);
        }
    }

    /**
     * @return mixed
     */
    public function getTipoPagamento()
    {
        return $this->tipo_pagamento;
    }

    /**
     * @param mixed $tipo_pagamento
     */
    public function setTipoPagamento($tipo_pagamento)
    {
        $this->tipo_pagamento = $tipo_pagamento;
    }

    public function setTipoPagamentoAttribute($tipoPagamento)
    {
        $this->attributes['tipo_pagamento'] = $tipoPagamento;
        $this->setTotalComissaoFonte($this->getIdFonte(), $this->getTipoPagamento(), $this->getValorTotal());
    }

    public function getSaldoPagar()
    {
        return $this->getValorTotal() - $this->getTotalPago();
    }

    private function setTotalComissaoFonte($idFonte, $metodoPagamento, $total)
    {
        if (!empty($idFonte) && !empty($metodoPagamento) && !empty($total)) {
            $fonte = FonteReserva::find($idFonte);
            switch ($metodoPagamento) {
                case MetodoPagamento::$AVISTA:
                    $percentagem = $fonte->getPercentagemVista();
                    break;
                case MetodoPagamento::$PARCELADO:
                    $percentagem = $fonte->getPercentagemParcelado();
                    break;
                default:
                    $percentagem = 0;
                    break;
            }
            $this->attributes['total_comissao_fonte'] = $total * ( $percentagem / 100 );
        }
    }

    /**
     * @return mixed
     */
    public function getTotalComissaoFonte()
    {
        return $this->total_comissao_fonte;
    }


    public function getTotalPago()
    {
        return $this->pagamentos()->sum('quantia');
    }

    public function getClienteReservante()
    {
        return $this->clienteReservante;
    }

    public function clienteReservante()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente_reservante', 'id');
    }

    public function setIdQuartoAttribute($id)
    {
        $this->attributes['id_quarto'] = $id;
        if (!empty($this->attributes['data_saida']) && !empty($this->attributes['data_entrada'])) {
            $this->setValorTotalFromDias($this->attributes['data_entrada'], $this->attributes['data_saida']);
        }
    }

    public function checkCheckinDisponivel()
    {
        return Carbon::createFromFormat('d/m/Y', $this->getDataEntrada())->isSameDay(Carbon::now());
    }

    public function estada()
    {
        return $this->hasOne(Estada::class, 'id_reserva', 'id');
    }

    public function getQuarto()
    {
        return $this->quarto;
    }

    public function quarto()
    {
        return $this->belongsTo(Quarto::class, 'id_quarto', 'id');
    }

    public function getPagamentos()
    {
        return $this->pagamentos;
    }

    public function pagamentos()
    {
        return $this->hasMany(PagamentoReserva::class, 'id_reserva', 'id');
    }

    public function getFonte()
    {
        return $this->fonte;
    }

    public function fonte()
    {
        return $this->belongsTo(FonteReserva::class, 'id_fonte', 'id');
    }

    public function getComissionista()
    {
        return $this->comissionista;
    }

    public function comissionista()
    {
        return $this->belongsTo(Comissionista::class, 'id_comissionista', 'id');
    }

    public function setIdComissionistaAttribute($id)
    {
        $this->attributes['id_comissionista'] = empty($id) ? null : $id;
        if (!empty($id) && !empty($this->attributes['valor_total'])) {
            $this->calcularComissao($this->attributes['valor_total'], $id);
        }
    }

    public function getCliente()
    {
        return $this->cliente;
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id');
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }

    public function checkEstadoReserva($quantia)
    {
        if ($this->getEstado() !== EstadoReserva::$CANCELADA) {
            $saldoAtualizado = $this->getTotalPago() + $quantia;
            if ($saldoAtualizado >= ($this->getValorTotal() / 2)) {
                $this->setEstado((string) EstadoReserva::$CONFIRMADA);
            } else {
                $this->setEstado((string) EstadoReserva::$ABERTA);
            }
        }
    }

    public function scopeConsultarIndisponibilidade($q, $dataInicio, $dataFim, $idReservaAtual = null)
    {
        $dataEntrada = $this->prettyDateToDBDate($dataInicio);
        $dataSaida = $this->prettyDateToDBDate($dataFim);
        $q = $q->where(function ($q) use($dataEntrada, $dataSaida) {
            $q->where(function($q) use($dataEntrada) {
                $q->whereDate('data_entrada', '<=', $dataEntrada)
                    ->whereDate('data_saida', '>', $dataEntrada);
            })
                ->orWhere(function($q) use($dataSaida) {
                    $q->whereDate('data_entrada', '<', $dataSaida)
                        ->whereDate('data_saida', '>=', $dataSaida);
                })
                ->orWhere(function($q) use($dataEntrada, $dataSaida) {
                    $q->whereDate('data_entrada', '>=', $dataEntrada)
                        ->whereDate('data_saida', '<=', $dataSaida);
                });
        });
        if (!is_null($idReservaAtual)) {
            $q = $q->where('id', '<>', $idReservaAtual);
        }
        return $q;
    }

    public static function validationRules(Request $request)
    {
        $path = strtolower($request->path());
        if (!str_contains($path, [
                'fontes-reservas',
                'registrar-pagamento',
                'estado-comissao'
            ]) && str_contains($path, 'reserva')) {
            switch (strtolower($request->method())) {
                case 'post':
                    return [
                        'id_cliente_reservante' => 'required',
                        'data_entrada' => 'required',
                        'data_saida' => 'required',
                        'id_quarto' => 'required',
                        'id_fonte' => 'required',
                    ];
                    break;
                case 'put':
                    return [
                        'data_entrada' => 'required',
                        'data_saida' => 'required',
                        'id_quarto' => 'required',
                    ];
                    break;
                default:
                    break;
            }
        } elseif ($path === 'registrar-pagamento')  {
            return [
                'quantia' => 'required|numeric|max:' . Reserva::find( $request->route('reserva') )->getSaldoPagar()
            ];
        }
        return [];
    }

    public static function authorizationVerification(Request $request)
    {
        return $request->user()->getTipo() === TipoUsuario::$ADMINISTRADOR
            ||
            !str_contains(strtolower($request->path()), [
                'fontes-reservas',
                'comissao-reserva'
            ])
            ||
            str_contains(strtolower($request->path()), [
                'registrar-pagamento',
                'saldo-reserva',
                'confirmar-reserva'
            ]);
    }

    public static function searchableFields()
    {
        return [
            'id',
            'data_entrada',
            'data_saida'
        ];
    }

    public static function messages()
    {
        return [
            'id_cliente_reservante.required' => 'A seleção de um cliente é obrigatória',
            'id_quarto.required' => 'A seleção de um quarto é obrigatória'
        ];
    }

}
