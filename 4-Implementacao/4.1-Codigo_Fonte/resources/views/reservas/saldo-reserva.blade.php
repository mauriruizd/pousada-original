@extends('master')
@section('title', 'Consulta de Saldo a Pagar')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('reservas.index') }}">Reservas</a>
    > <a href="{{ route('reservas.show', [$reserva->getId()]) }}">{{ $reserva->getQuarto()->getNumero() }} ({{ $reserva->getDataEntrada() }} - {{ $reserva->getDataSaida() }})</a>
    > Saldo a Pagar
@stop
@section('search-url', route('reservas.index'))
@section('content')
    <div class="loader"></div>
    <div class="row">
        <label class="col-md-12">Valor Total</label>
        <div class="col-md-12">
            R$ {{ $reserva->getValorTotal() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Total Saldo a Pagar</label>
        <div class="col-md-12">
            R$ {{ $reserva->getSaldoPagar() }}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('reservas.pagamento-form', [$reserva->getId()]) }}" class="btn btn-primary" {{ $reserva->getEstado() != \App\Entities\Enumeration\EstadoReserva::$CANCELADA ? '' : 'disabled' }}>
                Registrar Pagamento
            </a>
        </div>
    </div>
@stop
