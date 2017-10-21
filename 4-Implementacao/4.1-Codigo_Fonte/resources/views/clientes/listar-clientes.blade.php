@extends('master')
@section('title', 'Listado de Clientes')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Clientes
@stop
@section('search-url', route('clientes.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Clientes encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $clientes->count() }} clientes.</h4>
            <table class="table">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Documento de identidade</th>
                    <th>Imprimir Ficha</th>
                    <th>Detalhes</th>
                    <th>Editar</th>
                    <th>Arquivar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->getNome() }}</td>
                        <td>{{ $cliente->getRg() }}</td>
                        <td>
                            <a href="{{ route('clientes.ficha', [$cliente->getId()]) }}" class="btn btn-primary">
                                <i class="fa fa-print"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('clientes.show', [$cliente->getId()]) }}" class="btn btn-primary">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('clientes.edit', [$cliente->getId()]) }}" class="btn btn-primary">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                        <td>
                            {!! Form::open(['route' => ['clientes.destroy', $cliente->getId()], 'method' => 'delete']) !!}
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-archive"></i>
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        {!! $clientes->render() !!}
    </div>
    <div class="floating-menu">
        <div class="submenu">
            <a href="{{ route('clientes.arquivados') }}" class="btn btn-primary btn-rounded" title="Listar clientes arquivados">
                <i class="fa fa-archive"></i>
            </a>
            <a href="{{ route('clientes.create') }}" class="btn btn-rounded btn-primary" title="Criar novo registro de cliente">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop