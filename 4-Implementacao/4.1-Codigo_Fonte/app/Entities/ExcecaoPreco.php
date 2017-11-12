<?php

namespace App\Entities;

use App\Entities\Interfaces\SearchableEntity;
use App\Entities\Traits\DefaultSearchTrait;
use App\Entities\Traits\PrettyDateTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tree\Fixture\Transport\Car;

class ExcecaoPreco extends Model implements SearchableEntity
{
    use SoftDeletes,
        DefaultSearchTrait,
        PrettyDateTrait;

    protected $table = 'excecoes_precos';

    protected $fillable = [
        'id',
        'id_tipo_quarto',
        'preco',
        'data_inicio',
        'data_fim',
        'deleted_at'
    ];

    protected $dates = [
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
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdTipoQuarto()
    {
        return $this->idTipoQuarto;
    }

    /**
     * @param mixed $idTipoQuarto
     */
    public function setIdTipoQuarto($idTipoQuarto)
    {
        $this->idTipoQuarto = $idTipoQuarto;
    }

    /**
     * @return mixed
     */
    public function getPreco()
    {
        return $this->preco;
    }

    public function getTipoQuarto()
    {
        return $this->tipoQuarto;
    }

    /**
     * @param mixed $preco
     */
    public function setPreco($preco)
    {
        $this->preco = $preco;
    }

    /**
     * @return mixed
     */
    public function getDataInicio()
    {
        return $this->data_inicio;
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
        return $this->data_fim;
    }

    /**
     * @param mixed $dataFim
     */
    public function setDataFim($dataFim)
    {
        $this->dataFim = $dataFim;
    }

    public function getDataInicioAttribute($dataInicio)
    {
        return $this->getDate($dataInicio);
    }

    public function getDataFimAttribute($dataFim)
    {
        return $this->getDate($dataFim);
    }

    public function setDataInicioAttribute($dataInicio)
    {
        $this->setDate($dataInicio, 'data_inicio');
    }

    public function setDataFimAttribute($dataFim)
    {
        $this->setDate($dataFim, 'data_fim');
    }

    public function tipoQuarto()
    {
        return $this->belongsTo(TipoQuarto::class, 'id_tipo_quarto', 'id');
    }

    public function scopeDoTipo($q, $id)
    {
        return $q->where('id_tipo_quarto', '=', $id);
    }

    public function checarData($dataInicio, $dataFim)
    {
        $dataInicio = Carbon::createFromFormat('d/m/Y', $dataInicio);
        $dataFim = Carbon::createFromFormat('d/m/Y', $dataFim);
        $this->get
    }

    public static function searchableFields()
    {
        return [
            'preco',
            'data_inicio',
            'data_fim'
        ];
    }


}
