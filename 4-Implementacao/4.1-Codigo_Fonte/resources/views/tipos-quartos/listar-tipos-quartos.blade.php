@extends('master')
@section('title', 'Listagem de Tipos de Quartos')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Tipos de Quartos
@stop
@section('search-url', route('tipos-quartos.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Tipos de quartos encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $tiposQuartos->total() }} Tipos de Quartos.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Tipo de Quarto</th>
                <th>Detalhes</th>
                <th>Exceções de Preço</th>
                <th>Editar</th>
                <th>Arquivar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tiposQuartos as $tipoQuarto)
                <tr>
                    <td>{{ $tipoQuarto->getNome() }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('tipos-quartos.show', [$tipoQuarto->getId()]) }}">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('tipos-quartos.excecoes-precos.index', [$tipoQuarto->getId()]) }}">
                            <i class="fa fa-money"></i>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('tipos-quartos.edit', [$tipoQuarto->getId()]) }}">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                    <td>
                        {!! Form::open(['route' => ['tipos-quartos.destroy', $tipoQuarto->getId()], 'method' => 'delete']) !!}
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-archive"></i>
                            </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $tiposQuartos->render() !!}
    </div>
    <div class="floating-menu">
        <div class="submenu">
            <a href="{{ route('tipos-quartos.arquivados') }}" class="btn btn-primary btn-rounded" title="Listar tipos de quartos arquivados">
                <i class="fa fa-archive"></i>
            </a>
            <a href="{{ route('tipos-quartos.create') }}" class="btn btn-rounded btn-primary" title="Criar novo registro de tipo de quarto">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop