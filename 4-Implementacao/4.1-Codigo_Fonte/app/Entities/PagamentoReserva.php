<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PagamentoReserva extends Model
{
    protected $table = 'pagamentos_reservas';
    protected $fillable = [
        'quantia',
        'datahora',
        'id_reserva'
    ];

    /**
     * @return mixed
     */
    public function getQuantia()
    {
        return $this->quantia;
    }

    /**
     * @param mixed $quantia
     */
    public function setQuantia($quantia)
    {
        $this->quantia = $quantia;
    }

    public function setQuantiaAttribute($quantia)
    {
        $this->attributes['quantia'] = $quantia;
        $this->checkEstadoReserva($this->attributes['id_reserva'], $quantia);
    }

    /**
     * @return mixed
     */
    public function getDatahora()
    {
        return $this->datahora;
    }

    /**
     * @param mixed $datahora
     */
    public function setDatahora($datahora)
    {
        $this->datahora = $datahora;
    }

    /**
     * @return mixed
     */
    public function getIdReserva()
    {
        return $this->id_reserva;
    }

    /**
     * @param mixed $id_reserva
     */
    public function setIdReserva($id_reserva)
    {
        $this->id_reserva = $id_reserva;
    }

    public function setIdReservaAttribute($idReserva)
    {
        $this->attributes['id_reserva'] = $idReserva;
        if (!empty($this->attributes['quantia'])) {
            $this->checkEstadoReserva($idReserva, $this->attributes['quantia']);
        }
    }

    public function checkEstadoReserva($idReserva, $quantiaPaga)
    {
        if (!empty($idReserva) && !empty($quantiaPaga)) {
            $reserva = Reserva::find($idReserva);
            $reserva->checkEstadoReserva($quantiaPaga);
            $reserva->save();
        }
    }

    public function getReserva()
    {
        return $this->reserva;
    }

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_reserva', 'id');
    }
}
