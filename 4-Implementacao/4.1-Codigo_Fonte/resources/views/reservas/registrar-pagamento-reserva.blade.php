@extends('master')
@section('title', 'Registrar Pagamento de Reserva')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('reservas.index') }}">Reservas</a>
    > <a href="{{ route('reservas.show', [$reserva->getId()]) }}">{{ $reserva->getQuarto()->getNumero() }} ({{ $reserva->getDataEntrada() }} - {{ $reserva->getDataSaida() }})</a>
    > Editar
@stop
@section('search-url', route('reservas.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => ['reservas.pagamento', $reserva->getId()], 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    <div class="row">
        <label class="col-md-12">Valor Total</label>
        <div class="col-md-12">
            R$ {{ $reserva->getValorTotal() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Total Pago</label>
        <div class="col-md-12">
            R$ {{ $reserva->getTotalPago() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Total Saldo a Pagar</label>
        <div class="col-md-12">
            R$ {{ $reserva->getSaldoPagar() }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12">Quantia a Pagar</label>
        <div class="col-md-12">
            {!! Form::number('quantia', $reserva->getSaldoPagar(), ['class' => 'form-control form-control-line', 'required', 'max' => $reserva->getSaldoPagar(), 'min' => 1, 'step' => '0.01']) !!}
        </div>
    </div>
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop
