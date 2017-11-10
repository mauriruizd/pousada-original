<?php

namespace App\Entities;

use App\Entities\Enumeration\TipoUsuario;
use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SearchableEntity;
use App\Entities\Traits\DefaultSearchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Comissionista extends Model implements EntityValidation, SearchableEntity
{
    use SoftDeletes,
        DefaultSearchTrait;

    protected $fillable = [
        'id',
        'nome',
        'telefone',
        'percentagem',
        'id_categoria',
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
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    /**
     * @return mixed
     */
    public function getPercentagem()
    {
        return $this->percentagem;
    }

    /**
     * @param mixed $percentagem
     */
    public function setPercentagem($percentagem)
    {
        $this->percentagem = $percentagem;
    }

    /**
     * @return mixed
     */
    public function getIdCategoria()
    {
        return $this->id_categoria;
    }

    /**
     * @param mixed $id_categoria
     */
    public function setIdCategoria($id_categoria)
    {
        $this->id_categoria = $id_categoria;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaComissionista::class, 'id_categoria', 'id');
    }

    public static function validationRules(Request $request)
    {
        if (str_contains(strtolower($request->method()), [
            'post',
            'put'
        ])) {
            if (str_contains(strtolower($request->path()), ['modificar-percentagem-comissao'])) {
                return [
                    'percentagem' => 'required|numeric|min:' . Comissionista::find($request->route('id'))->getPercentagem()
                ];
            }
            return [
                'nome'
            ];
        }
        return [];
    }

    public static function authorizationVerification(Request $request)
    {
        return $request->user()->getTipo() === TipoUsuario::$ADMINISTRADOR
            ||
            (
                strtolower($request->path()) === 'comissionistas' ||
                str_contains(strtolower($request->path()), 'show')
            );
    }

    public static function searchableFields()
    {
        return [
            'id',
            'nome',
            'telefone'
        ];
    }


}
