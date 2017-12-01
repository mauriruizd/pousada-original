<?php

namespace App\Entities;

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
        'comissao_paga',
        'id_cliente_reservante',
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
        if (!empty($this->attributes['data_saida']) && !empty($this->attributes['id_quarto'])) {
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
        if (!empty($this->attributes['data_entrada']) && !empty($this->attributes['id_quarto'])) {
            $this->setValorTotalFromDias($this->attributes['data_entrada'], $this->attributes['data_saida']);
        }
    }

    private function setValorTotalFromDias($dataEntrada, $dataSaida)
    {
        $tipoQuarto = Quarto::find($this->attributes['id_quarto'])->getTipoQuarto();
        $excecoes = $tipoQuarto->excecoes()
            ->where(function($q) use($dataEntrada) {
                $q->whereDate('data_inicio', '<=', $dataEntrada)
                    ->whereDate('data_fim', '>=', $dataEntrada);
            })
            ->orWhere(function($q) use($dataSaida) {
                $q->whereDate('data_inicio', '<=', $dataSaida)
                    ->whereDate('data_fim', '>=', $dataSaida);
            })
            ->orWhere(function($q) use($dataEntrada, $dataSaida) {
                $q->whereDate('data_inicio', '>=', $dataEntrada)
                    ->whereDate('data_fim', '<=', $dataSaida);
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
        if (!empty($this->attributes['id_comissionista'])) {
            $this->calcularComissao($total, $this->attributes['id_comissionista']);
        }
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

    public function getSaldoPagar()
    {
        return $this->getValorTotal() - $this->getTotalPago();
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
        if (!empty($this->attributes['data_entrada']) && !empty($this->attributes['data_saida'])) {
            $this->setValorTotalFromDias($this->attributes['data_entrada'], $this->attributes['data_saida']);
        }
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
        return $this->belongsTo(Comissionista::class, 'id_comisionista', 'id');
    }

    public function setIdComissionistaAttribute($id)
    {
        $this->attributes['id_comissionista'] = $id;
        if (!empty($this->attributes['valor_total'])) {
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

    public function scopeConsultarIndisponibilidade($q, $dataInicio, $dataFim)
    {
        $dataEntrada = $this->prettyDateToDBDate($dataInicio);
        $dataSaida = $this->prettyDateToDBDate($dataFim);
        return $q->where(function($q) use($dataEntrada) {
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
    }

    public static function validationRules(Request $request)
    {
        $path = strtolower($request->path());
        if (!str_contains($path, 'fontes-reservas') && str_contains($path, 'reserva')) {
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
                        'id_cliente_reservante' => 'required',
                        'data_entrada' => 'required|date|after:' . Carbon::createFromFormat('Y-m-d', Reserva::find($request->route('reserva'))->getDataEntrada())->subDay(1),
                        'data_saida' => 'required|date|after:' . Carbon::createFromFormat('Y-m-d', Reserva::find($request->route('reserva'))->getDataEntrada()),
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
            !str_contains(strtolower($request->path()), 'fontes-reservas')
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
