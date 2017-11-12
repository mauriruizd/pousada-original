<?php

namespace App\Entities;

use App\Entities\Enumeration\TipoUsuario;
use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SearchableEntity;
use App\Entities\Traits\DefaultSearchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class FonteReserva extends Model implements EntityValidation, SearchableEntity
{
    use SoftDeletes,
        DefaultSearchTrait;

    protected $table = 'fontes_reservas';

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
        return $request->user()->getTipo() === TipoUsuario::$ADMINISTRADOR;
    }

    public static function searchableFields()
    {
        return [
            'nome'
        ];
    }


}
