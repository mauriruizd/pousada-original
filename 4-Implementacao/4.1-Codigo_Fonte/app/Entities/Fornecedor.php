<?php

namespace App\Entities;

use App\Entities\Enumeration\TipoUsuario;
use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SearchableEntity;
use App\Entities\Traits\DefaultSearchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Fornecedor extends Model implements EntityValidation, SearchableEntity
{
    use DefaultSearchTrait,
        SoftDeletes;

    protected $table = 'fornecedores';

    protected $fillable = [
        'id',
        'nome',
        'cnpj',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'id_cidade',
        'fone',
        'email',
        'site',
        'nome_encarregado'
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
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * @param mixed $cnpj
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    /**
     * @return mixed
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @param mixed $cep
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    /**
     * @return mixed
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @param mixed $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * @param mixed $complemento
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
    }

    /**
     * @return mixed
     */
    public function getIdCidade()
    {
        return $this->id_cidade;
    }

    /**
     * @param mixed $idCidade
     */
    public function setIdCidade($idCidade)
    {
        $this->id_cidade = $idCidade;
    }

    /**
     * @return mixed
     */
    public function getFone()
    {
        return $this->fone;
    }

    /**
     * @param mixed $fone
     */
    public function setFone($fone)
    {
        $this->fone = $fone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param mixed $site
     */
    public function setSite($site)
    {
        $this->site = $site;
    }

    /**
     * @return mixed
     */
    public function getNomeEncarregado()
    {
        return $this->nome_encarregado;
    }

    /**
     * @param mixed $nomeEncarregado
     */
    public function setNomeEncarregado($nomeEncarregado)
    {
        $this->nome_encarregado = $nomeEncarregado;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'id_cidade', 'id');
    }

    public static function validationRules(Request $request)
    {
        switch (true) {
            case str_contains(strtolower($request->method()), ['post', 'put']):
                return [
                    'nome' => 'required',
                    'cnpj' => 'required|size:14'
                ];
            default:
                return [];
        }
    }

    public static function authorizationVerification(Request $request)
    {
        return $request->user()->getTipo() === TipoUsuario::$ADMINISTRADOR;
    }

    public static function searchableFields()
    {
        return [
            'id',
            'nome',
            'cnpj'
        ];
    }


}
