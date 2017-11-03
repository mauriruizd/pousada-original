@extends('master')
@section('title', 'Listagem de Usuários')
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
                <th>Alterar Senha</th>
                <th>Arquivar</th>
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
                        <a href="{{ route('usuarios.form-alterar-senha', [$usuario->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-key"></i>
                        </a>
                    </td>
                    <td>
                        {!! Form::open(['route' => ['usuarios.destroy', $usuario->getId()], 'method' => 'delete']) !!}
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-archive"></i>
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
        <div class="submenu">
            <a href="{{ route('usuarios.arquivados') }}" class="btn btn-primary btn-rounded" title="Listar usuarios arquivados">
                <i class="fa fa-archive"></i>
            </a>
            <a href="{{ route('usuarios.create') }}" class="btn btn-rounded btn-primary" title="Criar novo registro de usuario">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop