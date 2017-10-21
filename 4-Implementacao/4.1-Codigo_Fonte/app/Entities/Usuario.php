<?php

namespace App\Entities;

use App\Entities\Enumeration\TipoUsuario;
use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SearchableEntity;
use App\Entities\Traits\DefaultSearchTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable implements EntityValidation, SearchableEntity
{
    protected $table = 'usuarios';

    protected $dates = [
        'deleted_at'
    ];

    use SoftDeletes;
    use Notifiable;
    use DefaultSearchTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'email', 'password', 'tipo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
        $this->password = $password;
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

    public function getAcessos()
    {
        return $this->acessos;
    }

    public function acessos()
    {
        return $this->hasMany(Acesso::class, 'id_usuario', 'id');
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function setPasswordAttribute($val)
    {
        $this->attributes['password'] = bcrypt($val);
    }

    public static function validationRules(Request $request)
    {
        if (str_contains($request->path(), 'alterar-senha')) {
            return [
                'password' => 'min:6|confirmed|max:254'
            ];
        } else {
            return [
                'nome' => 'required|max:254',
                'email' => 'required|email|max:254',
                'password' => 'min:6|confirmed|max:254'
            ];
        }
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
