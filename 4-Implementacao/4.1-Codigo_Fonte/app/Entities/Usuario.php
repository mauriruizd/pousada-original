<?php
namespace App\Entities;

use App\Entities\Enumeration\TipoUsuario;
use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SearchableEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use \Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="usuarios")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Usuario implements Authenticatable, CanResetPassword, EntityValidation, SearchableEntity
{
    use \LaravelDoctrine\ORM\Auth\Authenticatable;
    use \Illuminate\Auth\Passwords\CanResetPassword;

    /**
    * @ORM\Id
    * @ORM\GeneratedValue
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
    protected $password;

    /**
     * @ORM\Column(type="string")
     */
    protected $tipo;

    /**
     * @ORM\OneToMany(targetEntity="Acesso", mappedBy="usuario")
     */
    protected $acessos;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;

    public function __construct()
    {
        $this->acessos = new ArrayCollection();
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = Hash::make($password);
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getAcessos()
    {
        return $this->acessos;
    }

    /**
     * @param mixed $acessos
     */
    public function setAcessos($acessos)
    {
        $this->acessos = $acessos;
    }

    public function whitelist()
    {
        return [
            'nome',
            'email',
            'password',
            'tipo'
        ];
    }

    public static function validationRules()
    {
        return [
            'nome' => 'required',
            'email' => 'required|email',
            'password' => 'min:6|confirmed'
        ];
    }

    public static function authorizationVerification(Request $request)
    {
        if (strtolower($request->method()) === 'delete' && (int) $request->route('usuario') === $request->user()->getId()) {
            return false;
        }
        return $request->user()->getTipo() === TipoUsuario::$ADMINISTRADOR;
    }

    public static function searchableFields()
    {
        return [
            'id',
            'nome',
            'email'
        ];
    }

}