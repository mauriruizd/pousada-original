<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ConsumicaoFrigobar extends Model
{
    protected $table = 'consumicoes_frigobar';

    protected $fillable = [
        'id_cargo_conta',
        'id_produto',
        'preco',
        'quantidade',
        'subtotal'
    ];

    public function cargoConta()
    {
        return $this->belongsTo(CargoConta::class, 'id_cargo_conta', 'id');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto', 'id');
    }

    public function setIdProdutoAttribute($idProduto)
    {
        $this->attributes['id_produto'] = $idProduto;
        if (!empty($this->attributes['quantidade'])) {
            $this->updateStock($this->attributes['id_produto'], $this->attributes['quantidade']);
        }
    }

    public function setQuantidadeAttribute($quantidade)
    {
        $this->attributes['quantidade'] = $quantidade;
        if (!empty($this->attributes['id_produto'])) {
            $this->updateStock($this->attributes['id_produto'], $this->attributes['quantidade']);
        }
    }

    private function updateStock($idProduto, $quantidade)
    {
        $produto = Produto::find($idProduto);
        $produto->setEstoque($produto->getEstoque() - $quantidade);
        $produto->save();
    }
}
