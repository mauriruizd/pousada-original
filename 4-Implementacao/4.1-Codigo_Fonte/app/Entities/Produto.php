<?php

namespace App\Entities;

use App\Entities\Enumeration\TipoUsuario;
use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SearchableEntity;
use App\Entities\Traits\DefaultSearchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Produto extends Model implements EntityValidation, SearchableEntity
{
    use DefaultSearchTrait,
        SoftDeletes;

    protected $fillable = [
        'id',
        'nome',
        'id_categoria',
        'id_fornecedor',
        'estoque_inicial',
        'estoque_minimo',
        'estoque',
        'imagen_url'
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
    public function getIdCategoria()
    {
        return $this->id_categoria;
    }

    /**
     * @param mixed $idCategoria
     */
    public function setIdCategoria($idCategoria)
    {
        $this->id_categoria = $idCategoria;
    }

    /**
     * @return mixed
     */
    public function getIdFornecedor()
    {
        return $this->id_fornecedor;
    }

    /**
     * @param mixed $idFornecedor
     */
    public function setIdFornecedor($idFornecedor)
    {
        $this->id_fornecedor = $idFornecedor;
    }

    /**
     * @return mixed
     */
    public function getEstoqueInicial()
    {
        return $this->estoque_inicial;
    }

    /**
     * @param mixed $estoqueInicial
     */
    public function setEstoqueInicial($estoqueInicial)
    {
        $this->estoque_inicial = $estoqueInicial;
    }

    /**
     * @return mixed
     */
    public function getEstoqueMinimo()
    {
        return $this->estoque_minimo;
    }

    /**
     * @param mixed $estoqueMinimo
     */
    public function setEstoqueMinimo($estoqueMinimo)
    {
        $this->estoque_minimo = $estoqueMinimo;
    }

    public function setEstoqueMinimoAttribute($novoEstoqueMinimo)
    {
        if ($novoEstoqueMinimo > $this->getEstoque()) {
            abort(403);
        } elseif ($novoEstoqueMinimo > ($this->getEstoque() - 5)) {
            session()->flash('warning', 'ATENÇÃO! Estoque próximo ao mínimo. Estoque mínimo: ' . $this->getEstoqueMinimo());
        }
        $this->attributes['estoque_minimo'] = $novoEstoqueMinimo;
    }

    /**
     * @return mixed
     */
    public function getEstoque()
    {
        return $this->estoque;
    }

    /**
     * @param mixed $estoque
     */
    public function setEstoque($estoque)
    {
        $this->estoque = $estoque;
    }

    public function setEstoqueAttribute($novoEstoque)
    {
        if ($novoEstoque < $this->getEstoqueMinimo()) {
            abort(403);
        } elseif ($novoEstoque < $this->getEstoqueMinimo() + 5) {
            session()->flash('warning', 'ATENÇÃO! Estoque próximo ao mínimo. Estoque mínimo: ' . $this->getEstoqueMinimo());
        }
        $this->attributes['estoque'] = $novoEstoque;
    }

    /**
     * @return mixed
     */
    public function getImagenUrl()
    {
        return $this->imagen_url;
    }

    /**
     * @param mixed $imagenUrl
     */
    public function setImagenUrl($imagenUrl)
    {
        $this->imagen_url = $imagenUrl;
    }

    public function getFornecedor()
    {
        return $this->fornecedor;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function getPrecos()
    {
        return $this->precos;
    }

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class, 'id_fornecedor', 'id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id');
    }

    public function precos()
    {
        return $this->hasMany(PrecoProduto::class, 'id_produto', 'id');
    }

    public static function validationRules(Request $request)
    {
        if (strtolower($request->method()) == 'put') {
            $produto = static::find($request->route('produto'));
            return [
                'estoque_inicial' => 'numeric|min:' . $produto->getEstoqueMinimo() . '|min:' . $produto->getEstoque()
            ];
        }
        return [
            'estoque_inicial' => 'numeric|min:' . $request->estoque_minimo
        ];
    }

    public static function authorizationVerification(Request $request)
    {
        $paths = [
            'listado-produtos',
            'estoque/aumentar'
        ];
        if (str_contains($request->path(), $paths)) {
            return true;
        }
        return $request->user()->getTipo() == TipoUsuario::$ADMINISTRADOR;
    }

    public static function searchableFields()
    {
        return [
            'id',
            'nome'
        ];
    }


}
