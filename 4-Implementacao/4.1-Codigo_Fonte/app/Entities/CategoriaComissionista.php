<?php

namespace App\Entities;

use App\Entities\Enumeration\TipoUsuario;
use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SearchableEntity;
use App\Entities\Traits\DefaultSearchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class CategoriaComissionista extends Model implements EntityValidation, SearchableEntity
{
    use SoftDeletes,
        DefaultSearchTrait;

    protected $table = 'categorias_comissionistas';

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

    public function comissionistas()
    {
        return $this->hasMany(Comissionista::class, 'id_categoria', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function($categoria) {
            $categoria->comissionistas()->delete();
        });

        static::restored(function($categoria) {
            $categoria->comissionistas()->restore();
        });
    }


    public static function validationRules(Request $request)
    {
        if (str_contains(strtolower($request->method()), [
            'post',
            'put'
        ])) {
            return [
                'nome' => 'required'
            ];
        }
        return [];
    }

    public static function authorizationVerification(Request $request)
    {
        return (
            strtolower($request->method() === 'get')
            && !str_contains(strtolower($request->path()), 'edit')
            ) || $request->user()->getTipo() === TipoUsuario::$ADMINISTRADOR;
    }

    public static function searchableFields()
    {
        return [
            'id',
            'nome'
        ];
    }


}
