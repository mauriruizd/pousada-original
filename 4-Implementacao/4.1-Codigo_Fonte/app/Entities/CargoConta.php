<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class CargoConta extends Model
{
    protected $table = 'cargos_contas';

    protected $fillable = [
        'id',
        'id_estada',
        'id_usuario',
        'valor',
        'motivo'
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
    public function getIdEstada()
    {
        return $this->id_estada;
    }

    /**
     * @param mixed $id_estada
     */
    public function setIdEstada($id_estada)
    {
        $this->id_estada = $id_estada;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    /**
     * @param mixed $id_usuario
     */
    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @return mixed
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * @param mixed $motivo
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
    }

    public function estada()
    {
        return $this->belongsTo(Estada::class, 'id_estada', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }
}
