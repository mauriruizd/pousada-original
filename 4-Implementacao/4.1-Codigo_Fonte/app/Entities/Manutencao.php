<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Manutencao extends Model
{
    protected $table = 'manutencoes';

    protected $fillable = [
        'id',
        'id_quarto',
        'data_inicio',
        'data_fim',
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
    public function getIdQuarto()
    {
        return $this->idQuarto;
    }

    /**
     * @param mixed $idQuarto
     */
    public function setIdQuarto($idQuarto)
    {
        $this->idQuarto = $idQuarto;
    }

    /**
     * @return mixed
     */
    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    /**
     * @param mixed $dataInicio
     */
    public function setDataInicio($dataInicio)
    {
        $this->dataInicio = $dataInicio;
    }

    /**
     * @return mixed
     */
    public function getDataFim()
    {
        return $this->dataFim;
    }

    /**
     * @param mixed $dataFim
     */
    public function setDataFim($dataFim)
    {
        $this->dataFim = $dataFim;
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

    public function quarto()
    {
        return $this->belongsTo(Quarto::class, 'id_quarto', 'id');
    }

    public function scopeAberta($q)
    {
        return $q->where('data_fim', '=', null)->first();
    }

}
