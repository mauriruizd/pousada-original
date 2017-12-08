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
        'nome',
        'pagamento_vista',
        'pagamento_parcelado',
        'percentagem_vista',
        'percentagem_parcelado'
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
    public function getPagamentoVista()
    {
        return $this->pagamento_vista;
    }

    /**
     * @param mixed $pagamento_vista
     */
    public function setPagamentoVista($pagamento_vista)
    {
        $this->pagamento_vista = $pagamento_vista;
    }

    /**
     * @return mixed
     */
    public function getPagamentoParcelado()
    {
        return $this->pagamento_parcelado;
    }

    /**
     * @param mixed $pagamento_parcelado
     */
    public function setPagamentoParcelado($pagamento_parcelado)
    {
        $this->pagamento_parcelado = $pagamento_parcelado;
    }

    /**
     * @return mixed
     */
    public function getPercentagemVista()
    {
        return $this->percentagem_vista;
    }

    /**
     * @param mixed $percentagem_vista
     */
    public function setPercentagemVista($percentagem_vista)
    {
        $this->percentagem_vista = $percentagem_vista;
    }

    /**
     * @return mixed
     */
    public function getPercentagemParcelado()
    {
        return $this->percentagem_parcelado;
    }

    /**
     * @param mixed $percentagem_parcelado
     */
    public function setPercentagemParcelado($percentagem_parcelado)
    {
        $this->percentagem_parcelado = $percentagem_parcelado;
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
