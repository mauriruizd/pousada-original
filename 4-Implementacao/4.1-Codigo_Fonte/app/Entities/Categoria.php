<?php

namespace App\Entities;

use App\Entities\Enumeration\TipoUsuario;
use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SearchableEntity;
use App\Entities\Traits\DefaultSearchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Categoria extends Model implements EntityValidation, SearchableEntity
{
    use DefaultSearchTrait,
        SoftDeletes;

    protected $fillable = [
        'id',
        'nome'
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

    public function getProdutos()
    {
        return $this->produtos;
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class, 'id_categoria', 'id');
    }


    protected static function boot()
    {
        parent::boot();

        static::deleted(function($categoria) {
            $categoria->produtos()->delete();
        });

        static::restored(function($categoria) {
            $categoria->produtos()->restore();
        });
    }


    public static function validationRules(Request $request)
    {
        if (str_contains(strtolower($request->method()), [ 'post', 'put'])) {
            return [
                'nome' => 'required'
            ];
        }
        return [];
    }

    public static function authorizationVerification(Request $request)
    {
        return $request->user()->getTipo() === TipoUsuario::$ADMINISTRADOR;
    }

    public static function searchableFields()
    {
        return [
            'id',
            'nome'
        ];
    }

}
