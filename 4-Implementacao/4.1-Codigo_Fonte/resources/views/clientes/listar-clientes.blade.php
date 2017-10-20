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
                <th>Eliminar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->rg }}</td>
                    <td>
                        <a href="{{ route('clientes.ficha', [$cliente->id]) }}" class="btn btn-primary">
                            <i class="fa fa-print"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('clientes.show', [$cliente->id]) }}" class="btn btn-primary">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('clientes.edit', [$cliente->id]) }}" class="btn btn-primary">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                    <td>
                        {!! Form::open(['route' => ['clientes.destroy', $cliente->id], 'method' => 'delete']) !!}
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-trash"></i>
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
        <a href="{{ route('clientes.create') }}" class="btn btn-rounded btn-lg btn-primary">
            <i class="fa fa-plus"></i>
        </a>
    </div>
@stop