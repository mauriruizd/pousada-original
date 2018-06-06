@extends('master')
@section('title', 'Abrir Caixa')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('caixas.index') }}">Caixa</a>
    > Aberto
@stop
@section('search-url', route('caixas.index'))
@section('content')
    <div class="loader"></div>
    <div class="row">
        <div class="col-md-4">
            <label class="col-md-12">Data e hora de apertura</label>
            <span class="col-md-12">{{ $caixa->getDataHoraApertura() }}</span>
        </div>
        <div class="col-md-4">
            <label class="col-md-12">Quantia inicial</label>
            <span class="col-md-12">R$ {{ $caixa->quantidade_inicial }}</span>
        </div>
        <div class="col-md-4">
            <label class="col-md-12">Total no caixa</label>
            <span class="col-md-12">R$ {{ $caixa->valor_total }}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th>Data e hora</th>
                    <th>Entrada/Saída</th>
                    <th>Motivo</th>
                    <th>Valor</th>
                </tr>
                </thead>
                <tbody>
                @foreach($caixa->movimentos as $movimento)
                    <tr class="bg-{{ $movimento->tipo == \App\Entities\Enumeration\TipoMovimento::$ENTRADA ? 'success' : 'warning' }}">
                        <td>{{ $movimento->getDataHoraLancamento() }}</td>
                        <td>
                            @if($movimento->tipo == \App\Entities\Enumeration\TipoMovimento::$ENTRADA)
                                Entrada
                            @else
                                Saída
                            @endif
                        </td>
                        <td>{{ $movimento->motivo }}</td>
                        <td>R$ {{ $movimento->valor }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if(count($caixa->movimentos) == 0)
            <div class="col-md-12 text-center">
                <i>Não foram registrados movimentos ainda.</i>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-4">
            {!! Form::open(['route' => 'caixas.fechar', 'method' => 'DELETE']) !!}
            <button class="btn btn-primary" type="submit">Fechar Caixa</button>
            {!! Form::close() !!}
        </div>
        <div class="col-md-4">
            <a href="{{ route('caixas.create-deposito') }}" class="btn btn-primary">Registrar Deposito</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('caixas.create-saque') }}" class="btn btn-primary">Registrar Saque</a>
        </div>
    </div>
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop