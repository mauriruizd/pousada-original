<?php

namespace App\Entities;

use App\Entities\Cidade;
use App\Entities\Enumeration\Sexo;
use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SearchableEntity;
use App\Entities\Pais;
use App\Entities\Traits\DefaultSearchTrait;
use App\Entities\Traits\PrettyDateTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Cliente extends Model implements SearchableEntity, EntityValidation
{
    use DefaultSearchTrait,
        SoftDeletes,
        PrettyDateTrait;

    protected $dates = [
        'data_nascimento',
        'deleted_at'
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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @return mixed
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * @return mixed
     */
    public function getProfissao()
    {
        return $this->profissao;
    }

    /**
     * @return mixed
     */
    public function getIdNacionalidade()
    {
        return $this->id_nacionalidade;
    }

    /**
     * @return mixed
     */
    public function getDataNascimento()
    {
        return $this->data_nascimento;
    }

    /**
     * @return mixed
     */
    public function getRg()
    {
        return $this->rg;
    }

    /**
     * @return mixed
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @return mixed
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * @return mixed
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @return mixed
     */
    public function getIdCidade()
    {
        return $this->id_cidade;
    }

    /**
     * @return mixed
     */
    public function getObservacoes()
    {
        return $this->observacoes;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function getNacionalidade()
    {
        return $this->nacionalidade;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    /**
     * @param mixed $celular
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
    }

    /**
     * @param mixed $profissao
     */
    public function setProfissao($profissao)
    {
        $this->profissao = $profissao;
    }

    /**
     * @param mixed $idNacionalidade
     */
    public function setIdNacionalidade($idNacionalidade)
    {
        $this->id_nacionalidade = $idNacionalidade;
    }

    /**
     * @param mixed $dataNascimento
     */
    public function setDataNascimento($dataNascimento)
    {
        $this->data_nascimento = $dataNascimento;
    }

    /**
     * @param mixed $rg
     */
    public function setRg($rg)
    {
        $this->rg = $rg;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @param mixed $sexo
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    /**
     * @param mixed $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    /**
     * @param mixed $idCidade
     */
    public function setIdCidade($idCidade)
    {
        $this->id_cidade = $idCidade;
    }

    /**
     * @param mixed $observacoes
     */
    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;
    }

    /**
     * @param mixed $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->id_usuario = $idUsuario;
    }

    public function getDataNascimentoAttribute($date)
    {
        return $this->getDate($date);
    }

    public function setDataNascimentoAttribute($dateString)
    {
        $this->setDate($dateString, 'data_nascimento');
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

    private static function validaCPF($cpf) {

        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return "@";
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return "@";
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return "@";
            }
        }
        return $cpf;
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
            'cpf' => 'size:11|in:' . Cliente::validaCPF($request->cpf),
            'sexo' => 'required|in:' . Sexo::$MASCULINO, ',' . Sexo::$FEMININO,
            'id_cidade' => 'required',
            'endereco' => 'required|max:254',
        ];
    }

    public static function messages()
    {
        return [
            'cpf.in' => 'CPF não valido'
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
