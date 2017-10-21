@extends('master')
@section('title', 'Alterar Senha do Usuário')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('usuarios.index') }}">Usuários</a>
    > <a href="{{ route('usuarios.show', [$usuario->getId()]) }}">{{ $usuario->getNome() }}</a>
    > Alterar Senha
@stop
@section('search-url', route('usuarios.index'))
@section('content')
    {!! Form::open(['route' => ['usuarios.alterar-senha', $usuario->getId()], 'method' => 'PUT', 'class' => 'form-horizontal form-material']) !!}
    <div class="form-group">
        <label class="col-md-12">Senha</label>
        <div class="col-md-12">
            {!! Form::password('password', ['class' => 'form-control form-control-line', 'placeholder' => 'Insira sua senha. Mínimo de 6 caracteres', 'maxlength' => 254, isset($usuario) ? '' : 'required']) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-12">Confirmar Senha</label>
        <div class="col-md-12">
            {!! Form::password('password_confirmation', ['class' => 'form-control form-control-line', 'placeholder' => 'Insira sua senha. Mínimo de 6 caracteres', 'maxlength' => 254, isset($usuario) ? '' : 'required']) !!}
        </div>
    </div>

    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop