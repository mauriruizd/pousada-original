@extends('master')
@section('title', 'Listado de Produtos')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Relatório de Estoque de Produtos
@stop
@section('search-url', route('produtos.index'))
@section('content')
    <div class="row">
        <h4>Total de {{ $produtos->count() }} produtos.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Estoque Atual</th>
                <th>Estoque Mínimo</th>
            </tr>
            </thead>
            <tbody>
            @foreach($produtos as $produto)
                <tr>
                    <td>{{ $produto->getNome() }}</td>
                    <td>{{ $produto->getEstoque() }}</td>
                    <td>{{ $produto->getEstoqueMinimo() }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $produtos->render() !!}
    </div>
    <div class="floating-menu">
        <a href="{{ route('produtos.index') }}" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-arrow-circle-o-left"></i>
        </a>
    </div>
@stop