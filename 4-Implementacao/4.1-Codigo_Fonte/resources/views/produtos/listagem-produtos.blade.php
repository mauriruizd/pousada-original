@extends('master')
@section('title', 'Listado de Produtos')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('produtos.index') }}">Produtos</a>
    > Listagem
@stop
@section('search-url', route('produtos.index'))
@section('content')
    <div class="row">
        <div class="row text-right no-print">
            <button class="btn btn-primary" onclick="print()">
                <i class="fa fa-print"></i> Imprimir
            </button>
        </div>
        <h4>Total de {{ $produtos->count() }} produtos.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Preço</th>
            </tr>
            </thead>
            <tbody>
            @foreach($produtos as $produto)
                <tr>
                    <td>{{ $produto->getNome() }}</td>
                    <td>{{ $produto->getCategoria()->getNome() }}</td>
                    <td>R$ {{ $produto->getPrecos()->sortByDesc('datahora_cadastro')->first()->preco }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="floating-menu no-print">
        <a href="{{ route('produtos.index') }}" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-arrow-circle-o-left"></i>
        </a>
    </div>
@stop