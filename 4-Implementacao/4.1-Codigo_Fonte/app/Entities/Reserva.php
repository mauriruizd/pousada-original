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
        'data_entrada',
        'data_saida',
        'valor_total',
        'comissao_paga'
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
        if (!empty($this->getDataSaida())) {
            //
        }
    }

    public function getDataSaidaAttribute($date)
    {
        return $this->getDate($date);
    }

    public function setDataSaidaAttribute($dateString)
    {
        $this->setDate($dateString, 'data_saida');
    }

    private function setValorTotalFromDias($dataEntrada, $dataSaida)
    {
        $tipoQuarto = $this->getQuarto()->getTipoQuarto();
        $precoDiaria = $tipoQuarto->getPreco();
        $excecoes = $tipoQuarto->excecoes()
            ->where('data_inicio', '>', $dataEntrada)
    }

    private function calcularDiferenciaDias($dataEntrada, $dataSaida)
    {
        $dataEntrada = Carbon::createFromFormat('d/m/Y', $dataEntrada);
        $dataSaida = Carbon::createFromFormat('d/m/Y', $dataSaida);
        return $dataEntrada->diffInDays($dataSaida);
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

    public function getSaldoPagar()
    {
        return $this->getValorTotal() - $this->getTotalPago();
    }

    public function getTotalPago()
    {
        return $this->pagamentos()->sum('quantia');
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
        return $q->where('data_entrada', '<=', $dataInicio)
            ->where('data_saida', '>=', $dataFim);
    }

    public static function validationRules(Request $request)
    {
        $path = strtolower($request->path());
        if (!str_contains($path, 'fontes-reservas') && str_contains($path, 'reserva')) {
            switch (strtolower($request->method())) {
                case 'post':
                    return [
                        'clientes' => 'required',
                        'data_entrada' => 'required',
                        'data_saida' => 'required',
                        'id_quarto' => 'required',
                        'id_fonte' => 'required',
                    ];
                    break;
                case 'put':
                    return [
                        'clientes' => 'required',
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


}
