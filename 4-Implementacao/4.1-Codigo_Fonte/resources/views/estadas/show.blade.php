@extends('master')
@section('title', 'Detalhe da Estada')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('estadas.index') }}">Estadas</a>
    > Detalhes da Estada
@stop
@section('search-url', route('reservas.index'))
@section('content')
    <div class="loader"></div>
    <div class="row">
        <label class="col-md-12">Quarto</label>
        <div class="col-md-12">
            {{ $estada->getQuarto()->getNumero() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Numero de Diarias</label>
        <div class="col-md-12">
            {{ $estada->getNroDias() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Listado de Clientes</label>
        <div class="col-md-12">
            <ul>
                @foreach($estada->getHospedes() as $hospede)
                    <li>{{ $hospede->cliente->getNome() }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Total de Cargos</label>
        <div class="col-md-12">
            R$ {{ $estada->getTotalCargos() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Total Pago</label>
        <div class="col-md-12">
            R$ {{ $estada->getTotalPago() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Saldo</label>
        <div class="col-md-12">
            R$ {{ $estada->getSaldo() }}
        </div>
    </div>
@stop