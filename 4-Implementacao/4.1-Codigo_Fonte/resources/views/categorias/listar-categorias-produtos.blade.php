@extends('master')
@section('title', 'Listado de Categorias')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Categorias
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
                    <th>Editar</th>
                    <th>Arquivar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->getNome() }}</td>
                        <td>
                            <a href="{{ route('categorias.edit', [$categoria->getId()]) }}" class="btn btn-primary">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                        <td>
                            {!! Form::open(['route' => ['categorias.destroy', $categoria->getId()], 'method' => 'delete']) !!}
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-archive"></i>
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        {!! $categorias->render() !!}
    </div>
    <div class="floating-menu">
        <div class="submenu">
            <a href="{{ route('categorias.arquivados') }}" class="btn btn-primary btn-rounded" title="Listar categorias arquivados">
                <i class="fa fa-archive"></i>
            </a>
            <a href="{{ route('categorias.create') }}" class="btn btn-rounded btn-primary" title="Criar novo registro de categoria">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop