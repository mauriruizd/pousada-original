@extends('master')
@section('title', 'Listagem de Souvenirs')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Souvenirs
@stop
@section('search-url', route('souvenirs.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Souvenirs encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $souvenirs->count() }} souvenirs.</h4>
            <table class="table">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Detalhes</th>
                    <th>Editar</th>
                    <th>Arquivar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($souvenirs as $souvenir)
                    <tr>
                        <td>{{ $souvenir->getNome() }}</td>
                        <td>
                            <a href="{{ route('souvenirs.show', [$souvenir->getId()]) }}" class="btn btn-primary">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('souvenirs.edit', [$souvenir->getId()]) }}" class="btn btn-primary">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                        <td>
                            {!! Form::open(['route' => ['souvenirs.destroy', $souvenir->getId()], 'method' => 'delete']) !!}
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-archive"></i>
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        {!! $souvenirs->render() !!}
    </div>
    <div class="floating-menu">
        <div class="submenu">
            <a href="{{ route('souvenirs.arquivados') }}" class="btn btn-primary btn-rounded" title="Listar souvenirs arquivados">
                <i class="fa fa-archive"></i>
            </a>
            <a href="{{ route('souvenirs.create') }}" class="btn btn-rounded btn-primary" title="Criar novo registro de souvenir">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop