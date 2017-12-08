<?php

namespace App\Entities;

use App\Entities\Enumeration\TipoUsuario;
use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SearchableEntity;
use App\Entities\Traits\DefaultSearchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Quarto extends Model implements SearchableEntity, EntityValidation
{
    use SoftDeletes,
        DefaultSearchTrait;

    protected $fillable = [
        'id',
        'numero',
        'andar',
        'id_tipo_quarto',
        'em_manutencao'
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
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getAndar()
    {
        return $this->andar;
    }

    /**
     * @param mixed $andar
     */
    public function setAndar($andar)
    {
        $this->andar = $andar;
    }

    /**
     * @return mixed
     */
    public function getIdTipoQuarto()
    {
        return $this->id_tipo_quarto;
    }

    /**
     * @param mixed $idTipoQuarto
     */
    public function setIdTipoQuarto($idTipoQuarto)
    {
        $this->id_tipo_quarto = $idTipoQuarto;
    }

    /**
     * @return mixed
     */
    public function getEmManutencao()
    {
        return (boolean) $this->em_manutencao;
    }

    /**
     * @param mixed $emManutencao
     */
    public function setEmManutencao($emManutencao)
    {
        $this->em_manutencao = $emManutencao;
    }

    public function getTipoQuarto()
    {
        return $this->tipoQuarto;
    }

    public function getFotos()
    {
        return $this->fotos;
    }

    public function getManutencoes()
    {
        return $this->manutencoes;
    }

    public function tipoQuarto()
    {
        return $this->belongsTo(TipoQuarto::class, 'id_tipo_quarto', 'id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoQuarto::class, 'id_quarto', 'id');
    }

    public function manutencoes()
    {
        return $this->hasMany(Manutencao::class, 'id_quarto', 'id');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_quarto', 'id');
    }

    public function scopeEmManutencao($q)
    {
        return $q->where('em_manutencao', '=', false);
    }

    public function scopeConsultarDisponibilidade($q, $dataInicio, $dataFim, $idAtual = null)
    {
        $reservas = Reserva::consultarIndisponibilidade($dataInicio, $dataFim, $idAtual)->pluck('id_quarto');
        return $q->whereNotIn('id', $reservas);
    }

    public static function validationRules(Request $request)
    {
        $url = $request->path();
        switch (true) {
            case str_contains($url, 'promocao') : {
                if (strtolower($request->method()) !== 'delete') {
                    return [
                        'preco' => 'required|numeric'
                    ];
                }
                return [];
            }
            case str_contains($url, 'manutencao') : {
                if (strtolower($request->method()) === 'delete') {
                    return [];
                }
                return [
                    'motivo' => 'required'
                ];
            }
            default : {
                if (strtolower($request->method()) === 'put' || strtolower($request->method()) === 'delete') {
                    return [];
                }
                return [
                    'numero' => 'required|unique:quartos|max:3',
                    'andar' => 'required|numeric|max:3'
                ];
            }
        }
    }

    public static function authorizationVerification(Request $request)
    {
        if ($request->user()->getTipo() === TipoUsuario::$RECEPCIONISTA) {
            return strtolower($request->method() === 'get');
        }
        return true;
    }

    public static function searchableFields()
    {
        return [
            'numero',
        ];
    }
}
