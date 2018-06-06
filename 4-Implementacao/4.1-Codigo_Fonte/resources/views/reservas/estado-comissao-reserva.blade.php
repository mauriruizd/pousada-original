@extends('master')
@section('title', 'Consulta de Pagamento de Comissão')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('reservas.index') }}">Reservas</a>
    > <a href="{{ route('reservas.show', [$reserva->getId()]) }}">{{ $reserva->getQuarto()->getNumero() }} ({{ $reserva->getDataEntrada() }} - {{ $reserva->getDataSaida() }})</a>
    > Consulta de Pagamento de Comissão
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
        <label class="col-md-12">Comissionista</label>
        <div class="col-md-12">
            {{ $reserva->getComissionista()->getNome() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Percentagem</label>
        <div class="col-md-12">
            {{ $reserva->getComissionista()->getPercentagem() }} %
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Comissão</label>
        <div class="col-md-12">
            R$ {{ $reserva->getTotalComissao() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Estado</label>
        <div class="col-md-12">
            @if($reserva->getComissaoPaga())
                <span class="text-success">Paga</span>
            @else
                <span class="text-danger">Não paga</span>
            @endif
        </div>
    </div>
    @if(!$reserva->getComissaoPaga())
        {!! Form::open(['route' => ['reservas.confirmar-comissao', $reserva->getId()], 'method' => 'POST', 'onsubmit' => 'Confirma pagamento da comissão?']) !!}
        <div class="row">
            <div class="col-md-12">
                @if(auth()->user()->caixaAberto() == null)
                    <i class="text-danger">Não existe caixa aberto.</i>
                @else
                    <button type="submit" class="btn btn-primary" {{ $reserva->getEstado() != \App\Entities\Enumeration\EstadoReserva::$CANCELADA ? '' : 'disabled' }}>
                        Confirmar Pagamento
                    </button>
                @endif
            </div>
        </div>
        {!! Form::close() !!}
    @endif
@stop
