<?php
namespace App\Entities\Doctrine;

use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SaveableEntity;
use App\Entities\Interfaces\SearchableEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Illuminate\Http\Request;
use App\Entities\Enumeration\Sexo;

/**
 * Class Cliente
 * @package App\Entities
 * @ORM\Entity
 * @ORM\Table(name="clientes",
 *     indexes={
 *     @ORM\Index(name="nome_idx", columns={"nome"}),
 *     @ORM\Index(name="email_idx", columns={"email"}),
 *     @ORM\Index(name="telefone_idx", columns={"telefone"}),
 *     @ORM\Index(name="celular_idx", columns={"celular"}),
 *     @ORM\Index(name="dni_idx", columns={"dni"}),
 *     @ORM\Index(name="cpf_idx", columns={"cpf"})
 * })
 * @Gedmo\Softdeleteable(fieldName="deletedAt", timeAware=false)
 */
class Cliente implements SearchableEntity, EntityValidation, SaveableEntity
{
    /**
     * @ORM\GeneratedValue
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $telefone;

    /**
     * @ORM\Column(type="string")
     */
    protected $celular;

    /**
     * @ORM\Column(type="string")
     */
    protected $profissao;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Pais", cascade={"detach"})
     * @ORM\JoinColumn(name="nacionalidade", referencedColumnName="id")
     */
    protected $nacionalidade;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dataNascimento;

    /**
     * @ORM\Column(type="string")
     */
    protected $dni;

    /**
     * @ORM\Column(type="string")
     */
    protected $cpf;

    /**
     * @ORM\Column(type="string", length=1, options={"fixed" = true})
     */
    protected $genero;

    /**
     * @ORM\Column(type="string")
     */
    protected $endereco;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Cidade", cascade={"detach"})
     * @ORM\JoinColumn(name="id_cidade", referencedColumnName="id")
     */
    protected $cidade;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $observacoes;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
     */
    protected $usuario;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;

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
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    /**
     * @return mixed
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * @param mixed $celular
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
    }

    /**
     * @return mixed
     */
    public function getProfissao()
    {
        return $this->profissao;
    }

    /**
     * @param mixed $profissao
     */
    public function setProfissao($profissao)
    {
        $this->profissao = $profissao;
    }

    /**
     * @return mixed
     */
    public function getNacionalidade()
    {
        return $this->nacionalidade;
    }

    /**
     * @param mixed $nacionalidade
     */
    public function setNacionalidade($nacionalidade)
    {
        $this->nacionalidade = $nacionalidade;
    }

    /**
     * @return mixed
     */
    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    /**
     * @param mixed $dataNascimento
     */
    public function setDataNascimento($dataNascimento)
    {
        $this->dataNascimento = $dataNascimento;
    }

    /**
     * @return mixed
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param mixed $dni
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    /**
     * @return mixed
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @return mixed
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * @param mixed $genero
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;
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
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @param mixed $cidade
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    /**
     * @return mixed
     */
    public function getObservacoes()
    {
        return $this->observacoes;
    }

    /**
     * @param mixed $observacoes
     */
    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function whitelist()
    {
        return [
            'nome',
            'email',
            'telefone',
            'celular',
            'profissao',
            'nacionalidade',
            'dataNascimento',
            'dni',
            'cpf',
            'cidade',
            'genero',
            'endereco',
            'usuario',
            'observacoes'
        ];
    }

    public static function validationRules(Request $request)
    {
        return [
            'nome' => 'required|max:254',
            'email' => 'required|max:254',
            'telefone' => 'required|max:254',
            'celular' => 'required|max:254',
            'profissao' => 'required|max:254',
            'nacionalidade' => 'required|exists:App\Entities\Pais,id',
            'dataNascimento' => 'required|date_format:"d/m/Y"',
            'dni' => 'required|max:254',
            'cpf' => 'required|size:11',
            'genero' => 'required|in:' . Sexo::$MASCULINO, ',' . Sexo::$FEMININO,
            'cidade' => 'required',
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
            'dni',
            'cpf',
        ];
    }
}