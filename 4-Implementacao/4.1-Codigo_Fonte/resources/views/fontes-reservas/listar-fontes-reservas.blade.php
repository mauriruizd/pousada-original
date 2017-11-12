@extends('master')
@section('title', 'Listagem de Fontes')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Fontes
@stop
@section('search-url', route('fontes-reservas.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Fontes encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $fontes->count() }} fontes.</h4>
            <table class="table">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Editar</th>
                    <th>Arquivar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($fontes as $fonte)
                    <tr>
                        <td>{{ $fonte->getNome() }}</td>
                        <td>
                            <a href="{{ route('fontes-reservas.edit', [$fonte->getId()]) }}" class="btn btn-primary">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                        <td>
                            {!! Form::open(['route' => ['fontes-reservas.destroy', $fonte->getId()], 'method' => 'delete']) !!}
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-archive"></i>
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        {!! $fontes->render() !!}
    </div>
    <div class="floating-menu">
        <div class="submenu">
            <a href="{{ route('fontes-reservas.arquivados') }}" class="btn btn-primary btn-rounded" title="Listar fontes arquivados">
                <i class="fa fa-archive"></i>
            </a>
            <a href="{{ route('fontes-reservas.create') }}" class="btn btn-rounded btn-primary" title="Criar novo registro de fonte">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop