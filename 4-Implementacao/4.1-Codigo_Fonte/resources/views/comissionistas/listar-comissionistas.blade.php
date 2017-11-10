@extends('master')
@section('title', 'Listagem de Comissionistas')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Comissionistas
@stop
@section('search-url', route('comissionistas.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Comissionistas encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $comissionistas->count() }} comissionistas.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Detalhes</th>
                <th>Modificar Comissão</th>
                <th>Editar</th>
                <th>Arquivar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($comissionistas as $comissionista)
                <tr>
                    <td>{{ $comissionista->getNome() }}</td>
                    <td>{{ $comissionista->getCategoria()->getNome() }}</td>
                    <td>
                        <a href="{{ route('comissionistas.show', [$comissionista->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('comissionistas.form-percentagem', [$comissionista->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-percent"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('comissionistas.edit', [$comissionista->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                    <td>
                        {!! Form::open(['route' => ['comissionistas.destroy', $comissionista->getId()], 'method' => 'delete']) !!}
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-archive"></i>
                        </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $comissionistas->render() !!}
    </div>
    <div class="floating-menu">
        <div class="submenu">
            <a href="{{ route('comissionistas.arquivados') }}" class="btn btn-primary btn-rounded" title="Listar comissionistas arquivados">
                <i class="fa fa-archive"></i>
            </a>
            <a href="{{ route('comissionistas.create') }}" class="btn btn-rounded btn-primary" title="Criar novo registro de comissionista">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop