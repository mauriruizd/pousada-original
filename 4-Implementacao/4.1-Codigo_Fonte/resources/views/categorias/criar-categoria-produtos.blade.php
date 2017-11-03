@extends('master')
@section('title', 'Criar Categoria')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('categorias.index') }}">Categorias</a>
    > Novo
@stop
@section('search-url', route('categorias.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => 'categorias.store', 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    @include('categorias.form-categoria-produtos')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop