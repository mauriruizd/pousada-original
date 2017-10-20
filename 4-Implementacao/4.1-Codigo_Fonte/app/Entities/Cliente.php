<?php

namespace App\Entities;

use App\Entities\Cidade;
use App\Entities\Enumeration\Genero;
use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SearchableEntity;
use App\Entities\Pais;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cliente extends Model implements SearchableEntity, EntityValidation
{
    use DefaultSearchTrait;

    protected $dates = [
        'data_nascimento'
    ];

    protected $fillable = [
        'id',
        'nome',
        'email',
        'telefone',
        'celular',
        'profissao',
        'id_nacionalidade',
        'data_nascimento',
        'rg',
        'cpf',
        'sexo',
        'endereco',
        'id_cidade',
        'observacoes',
        'id_usuario',
        'deleted_at'
    ];

    public function setDataNascimentoAttribute($dateString)
    {
        $this->attributes['data_nascimento'] = implode('-', array_reverse(explode('/', $dateString))) . ' 00:00:00';
    }

    public function nacionalidade()
    {
        return $this->belongsTo(Pais::class, 'id_nacionalidade', 'id');
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'id_cidade', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }

    public static function validationRules(Request $request)
    {
        return [
            'nome' => 'required|max:254',
            'email' => 'required|max:254',
            'telefone' => 'required|max:254',
            'celular' => 'required|max:254',
            'profissao' => 'required|max:254',
            'id_nacionalidade' => 'required|exists:paises,id',
            'data_nascimento' => 'required|date_format:"d/m/Y"',
            'rg' => 'required|max:254',
            'cpf' => 'required|size:11',
            'sexo' => 'required|in:' . Genero::$MASCULINO, ',' . Genero::$FEMININO,
            'id_cidade' => 'required',
            'endereco' => 'required|max:254',
        ];
    }

    public static function authorizationVerification(Request $request)
    {
        return true;
    }

    public static function searchableFields()
    {
        return [
            'id',
            'nome',
            'email',
            'telefone',
            'celular',
            'rg',
            'cpf',
        ];
    }


}
