<?php

namespace App;

use App\Entities\Enumeration\TipoUsuario;
use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SearchableEntity;
use App\Entities\Traits\DefaultSearchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class Souvenir extends Model implements EntityValidation, SearchableEntity
{
    use DefaultSearchTrait,
        SoftDeletes;

    protected $fillable = [
        'id',
        'nome',
        'imagem_url',
        'preco'
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
    public function getImagemUrl()
    {
        return url($this->imagem_url);
    }

    /**
     * @param mixed $imagemUrl
     */
    public function setImagemUrl($imagemUrl)
    {
        $this->imagem_url = $imagemUrl;
    }

    public function setImagemUrlAttribute(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();
        $file->move(
            public_path('/uploads/img/souvenirs'),
            $fileName
        );
        $this->attributes['imagem_url'] = 'uploads/img/souvenirs/' . $fileName;
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

    public static function validationRules(Request $request)
    {
        if (str_contains(strtolower($request->method()), [
            'post',
            'put'
        ])) {
            return [
                'nome' => 'required',
                'preco' => 'required'
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
