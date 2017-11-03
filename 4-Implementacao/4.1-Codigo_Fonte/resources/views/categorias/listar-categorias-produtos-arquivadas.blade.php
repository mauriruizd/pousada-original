@extends('master')
@section('title', 'Listagem de Categorias Arquivados')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('categorias.index') }}">Categorias</a>
    > Arquivadas
@stop
@section('search-url', route('categorias.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Categorias encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $categorias->count() }} categorias.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Recuperar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categorias as $categoria)
                <tr>
                    <td>{{ $categoria->getNome() }}</td>
                    <td>
                        <a href="{{ route('categorias.recuperar', [$categoria->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $categorias->render() !!}
    </div>
    <div class="floating-menu">
        <a href="{{ route('categorias.index') }}" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-arrow-circle-o-left"></i>
        </a>
    </div>
@stop