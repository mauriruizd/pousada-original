@extends('master')
@section('title', 'Criar Usuário')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('usuarios.index') }}">Usuários</a>
    > Novo
@stop
@section('search-url', route('usuarios.index'))
@section('content')
    {!! Form::open(['route' => 'usuarios.store', 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    @include('usuarios.form-usuario')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop