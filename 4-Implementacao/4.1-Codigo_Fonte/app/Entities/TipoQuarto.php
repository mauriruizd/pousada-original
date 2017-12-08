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

class TipoQuarto extends Model implements EntityValidation, SearchableEntity
{
    use DefaultSearchTrait,
        SoftDeletes,
        PrettyDateTrait;

    protected $table = 'tipos_quartos';

    protected $fillable = [
        'id',
        'nome',
        'capacidade',
        'preco',
        'deleted_at'
    ];

    protected $dates = [
        'deleted_at'
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
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getCapacidade()
    {
        return $this->capacidade;
    }

    /**
     * @param mixed $capacidade
     */
    public function setCapacidade($capacidade)
    {
        $this->capacidade = $capacidade;
    }

    /**
     * @return mixed
     */
    public function getPreco()
    {
        return $this->preco;
    }

    /**
     * @param mixed $preco
     */
    public function setPreco($preco)
    {
        $this->preco = $preco;
    }

    public function getExcecoes()
    {
        return $this->excecoes;
    }

    public function excecoes()
    {
        return $this->hasMany(ExcecaoPreco::class, 'id_tipo_quarto', 'id');
    }

    public static function validationRules(Request $request)
    {
        if (strtolower($request->method()) !== 'delete') {
            switch (true) {
                case str_contains($request->path(), 'excecoes') : {
                    $tipoQuarto = TipoQuarto::find($request->route('tipos_quarto'));
                    $dataEntrada = implode('-', array_reverse(explode('/', $request->data_inicio))) . ' 00:00:00';
                    $dataSaida = implode('-', array_reverse(explode('/', $request->data_fim))) . ' 00:00:00';
                    $excecoes = ExcecaoPreco::where('id_tipo_quarto', $tipoQuarto->getId())
                        ->where(function($q) use ($dataEntrada, $dataSaida) {
                            $q
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
                                });
                        })
                        ->get();
                    if (count($excecoes) === 0) {
                        return [
                            'preco' => 'required|max:' . $tipoQuarto->getPreco()
                        ];
                    }
                    return [
                        'preco' => 'required|max:' . $tipoQuarto->getPreco(),
                        'data_inicio' => 'same:false',
                        'data_fim' => 'same:false'
                    ];
                }
                default: {
                    return [
                        'nome' => 'required',
                        'capacidade' => 'required',
                        'preco' => 'required'
                    ];
                }
            }
        }
        return [];
    }

    public static function authorizationVerification(Request $request)
    {
        return $request->user()->getTipo() === TipoUsuario::$ADMINISTRADOR;
    }

    public static function validationMessages(Request $request)
    {
        switch (true) {
            case str_contains($request->path(), 'excecoes') : {
                return [
                    'data_inicio.same' => 'A data de inicio interfere com outra exceção',
                    'data_fim.same' => 'A data de fim interfere com outra exceção',
                ];
            }
            case str_contains($request->path(), 'promocao') : {
                $method = strtolower($request->method());
                if ($method === 'post' || $method === 'put') {
                    return [
                        'preco.required' => 'O preco é obrigatório',
                        'preco.numeric' => 'O preço deve ter valor númerico',
                        'preco.min' => 'O preço deve ser um valor positivo',
                        'preco.max' => 'O preço deve ser inferior ao preco da diária do mês atual',
                    ];
                }
                break;
            }
        }
        return [];
    }

    public static function searchableFields()
    {
        return [
            'nome'
        ];
    }

}
