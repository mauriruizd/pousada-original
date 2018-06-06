@extends('master')
@section('title', 'Estado da Conta')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('estadas.index') }}">Estadas</a>
    > Estado da Conta
@stop
@section('search-url', route('reservas.index'))
@section('content')
    <div class="loader"></div>
    <div class="row">
        <label class="col-md-12">Total</label>
        <div class="col-md-12">
            R$ {{ $estada->getTotalCargos() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Credito</label>
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
    @if($estada->getSaldo() > 0)
        <div class="row">
            <div class="col-md-12">
                @if(auth()->user()->caixaAberto() == null)
                    <i class="text-danger">Não existe caixa aberto.</i>
                @else
                    <a href="{{ route('estadas.create-pagamento', [$estada->getId()]) }}" class="btn btn-primary">Efeituar Pagamento</a>
                @endif
            </div>
        </div>
    @endif
@stop