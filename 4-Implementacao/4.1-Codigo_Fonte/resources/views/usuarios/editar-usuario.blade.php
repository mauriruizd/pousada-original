@extends('master')
@section('title', 'Editar Usuário')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('usuarios.index') }}">Usuários</a>
    > <a href="{{ route('usuarios.show', [$usuario->getId()]) }}">{{ $usuario->getNome() }}</a>
    > Editar
@stop
@section('search-url', route('usuarios.index'))
@section('content')
    {!! Form::open(['route' => ['usuarios.update', $usuario->getId()], 'method' => 'PUT', 'class' => 'form-horizontal form-material']) !!}
    @include('usuarios.form-usuario')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop