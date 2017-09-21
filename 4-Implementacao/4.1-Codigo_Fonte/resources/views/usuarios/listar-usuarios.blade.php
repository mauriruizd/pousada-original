@extends('master')
@section('title', 'Listado de Usuários')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Usuários
@stop
@section('search-url', route('usuarios.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Usuários encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $usuarios->total() }} usuários.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Histórico de Acessos</th>
                <th>Detalhes</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ strlen($usuario->getNome()) > 40 ? (substr($usuario->getNome(), 0, 40) . '...') : $usuario->getNome() }}</td>
                    <td>
                        <a href="{{ route('usuarios.historico', [$usuario->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-table"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('usuarios.show', [$usuario->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('usuarios.edit', [$usuario->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                    <td>
                        {!! Form::open(['route' => ['usuarios.destroy', $usuario->getId()], 'method' => 'delete']) !!}
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-trash"></i>
                            </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $usuarios->render() !!}
    </div>
    <div class="floating-menu">
        <a href="{{ route('usuarios.create') }}" class="btn btn-rounded btn-lg btn-primary">
            <i class="fa fa-plus"></i>
        </a>
    </div>
@stop