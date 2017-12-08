@extends('master')
@section('title', 'Detalhe de Reserva')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('reservas.index') }}">Reservas</a>
    > {{ $reserva->getQuarto()->getNumero() }} ({{ $reserva->getDataEntrada() }} - {{ $reserva->getDataSaida() }})
@stop
@section('search-url', route('reservas.index'))
@section('content')
    <div class="row">
        <label class="col-md-12">Cliente Reservante</label>
        <div class="col-md-12">
            {{ $reserva->getClienteReservante()->getNome() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Data de Entrada</label>
        <div class="col-md-12">
            {{ $reserva->getDataEntrada() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Data de Saída</label>
        <div class="col-md-12">
            {{ $reserva->getDataSaida() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Quarto</label>
        <div class="col-md-12">
            {{ $reserva->getQuarto()->getNumero() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Fonte da Reserva</label>
        <div class="col-md-12">
            {{ $reserva->getFonte()->getNome() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Tipo de Pagamento</label>
        <div class="col-md-12">
            {{ $reserva->getTipoPagamento() === \App\Entities\Enumeration\MetodoPagamento::$PARCELADO ? 'Parcelado' : 'À vista' }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Comissionista</label>
        <div class="col-md-12">
            @if(!is_null($reserva->getComissionista()))
                {{ $reserva->getComissionista()->getNome() }}
            @else
                <i>Sem comissionista</i>
            @endif
        </div>
    </div>

    <div class="row">
        <label class="col-md-12">Valor Total</label>
        <div class="col-md-12">
            R$ {{ $reserva->getValorTotal() }}
        </div>
    </div>

    <div class="row">
        <label class="col-md-12">Estado</label>
        <div class="col-md-12">
            @if($reserva->getEstado() == \App\Entities\Enumeration\EstadoReserva::$ABERTA)
                <span class="text-warning">
                    Aberta
                </span>
            @elseif($reserva->getEstado() == \App\Entities\Enumeration\EstadoReserva::$CONFIRMADA)
                <span class="text-success">
                    Confirmada
                    <i class="fa fa-check"></i>
                </span>
            @else
                <span class="text-danger">
                    Cancelada
                    <i class="fa fa-times"></i>
                </span>
            @endif
        </div>
    </div>

    {{--<div class="floating-menu">--}}
        {{--<div class="submenu">--}}
            {{--<a href="{{ route('reservas.ficha', [$reserva->getId()]) }}" class="btn btn-primary btn-rounded">--}}
                {{--<i class="fa fa-print"></i>--}}
            {{--</a>--}}
            {{--{!! Form::open(['route' => ['reservas.destroy', $reserva->getId()], 'method' => 'delete']) !!}--}}
            {{--<button type="submit" class="btn btn-primary btn-rounded">--}}
                {{--<i class="fa fa-archive"></i>--}}
            {{--</button>--}}
            {{--{!! Form::close() !!}--}}
            {{--<a href="{{ route('reservas.edit', [$reserva->getId()]) }}" class="btn btn-primary btn-rounded">--}}
                {{--<i class="fa fa-pencil"></i>--}}
            {{--</a>--}}
        {{--</div>--}}
        {{--<button class="btn btn-primary btn-rounded btn-lg menu-main">--}}
            {{--<i class="fa fa-bars"></i>--}}
        {{--</button>--}}
    {{--</div>--}}
@stop