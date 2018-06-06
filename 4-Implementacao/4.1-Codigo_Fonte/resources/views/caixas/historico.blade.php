@extends('master')
@section('title', 'Historico de Caixa')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Caixa
@stop
@section('search-url', route('caixas.index'))
@section('content')
    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th>Data e hora de apertura</th>
                <th>Data e hora de fechamento</th>
                <th>Quantia Inicial</th>
                <th>Quantia Final</th>
            </tr>
            </thead>
            <tbody>
            @foreach($caixas as $caixa)
                <tr>
                    <td>{{ $caixa->getDataHoraApertura() }}</td>
                    <td>{{ $caixa->getDataHoraFechamento() }}</td>
                    <td>{{ $caixa->quantidade_inicial }}</td>
                    <td>{{ $caixa->valor_total }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $caixas->render() !!}
    </div>
    <div class="floating-menu">
        <a href="{{ route('caixas.create-abrir') }}" class="btn btn-primary btn-rounded btn-lg menu-main" title="Abrir caixa">
            <i class="fa fa-plus"></i>
        </a>
    </div>
@stop