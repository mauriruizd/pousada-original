@extends('master')
@section('title', 'Detalhe de Usuário')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('usuarios.index') }}">Usuários</a>
    > {{ $usuario->getNome() }}
@stop
@section('search-url', route('usuarios.index'))
@section('content')
    <div class="row">
        <label class="col-md-12">Nome</label>
        <p class="col-md-12">
            {{ $usuario->getNome() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">E-mail</label>
        <p class="col-md-12">
            {{ $usuario->getEmail() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Tipo</label>
        <p class="col-md-12">
            @if($usuario->getTipo() === \App\Entities\Enumeration\TipoUsuario::$RECEPCIONISTA)
                Recepcionista
            @elseif($usuario->getTipo() === \App\Entities\Enumeration\TipoUsuario::$ADMINISTRADOR)
                Administrador
            @endif
        </p>
    </div>
    <div class="floating-menu">
        <div class="submenu">
            <a href="{{ route('usuarios.historico', [$usuario->getId()]) }}" class="btn btn-primary btn-rounded">
                <i class="fa fa-table"></i>
            </a>
            {!! Form::open(['route' => ['usuarios.destroy', $usuario->getId()], 'method' => 'delete']) !!}
                <button type="submit" class="btn btn-primary btn-rounded">
                    <i class="fa fa-times"></i>
                </button>
            {!! Form::close() !!}
            <a href="{{ route('usuarios.edit', [$usuario->getId()]) }}" class="btn btn-primary btn-rounded">
                <i class="fa fa-pencil"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop