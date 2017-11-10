@extends('master')
@section('title', 'Criar Categoria')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('categorias-produtos.index') }}">Categorias</a>
    > Novo
@stop
@section('search-url', route('categorias-produtos.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => 'categorias-produtos.store', 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    @include('categorias-produtos.form-categoria-produtos')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop