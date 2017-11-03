@extends('master')
@section('title', 'Listado de Produtos Arquivados')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('produtos.index') }}">Produtos</a>
    > Arquivados
@stop
@section('search-url', route('produtos.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Produtos encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $produtos->count() }} produtos.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Recuperar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($produtos as $produto)
                <tr>
                    <td>{{ $produto->getNome() }}</td>
                    <td>
                        <a href="{{ route('produtos.recuperar', [$produto->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </td>
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