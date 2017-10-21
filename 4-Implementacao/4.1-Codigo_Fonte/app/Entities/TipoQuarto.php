<?php

namespace App\Entities;

use App\Entities\Enumeration\TipoUsuario;
use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SearchableEntity;
use App\Entities\Traits\DefaultSearchTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class TipoQuarto extends Model implements EntityValidation, SearchableEntity
{
    use DefaultSearchTrait;
    use SoftDeletes;

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
        if (!strtolower($request->method()) === 'delete') {
            switch (true) {
                case str_contains($request->path(), 'excecoes') : {
                    $tipoQuarto = TipoQuarto::find($request->route('tipos_quarto'));
                    return [
                        'preco' => 'required|max:' . $tipoQuarto->getPreco(),
                        'data_inicio' => 'after:' . Carbon::yesterday(),
                        'data_fim' => 'after:' . $request->data_inicio
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
            case str_contains($request->path(), 'tarifas') : {
                return [
                    'precos.*.numeric' => 'O preço deve ter valor númerico',
                    'precos.*.min' => 'O preço deve ser um valor positivo',
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
