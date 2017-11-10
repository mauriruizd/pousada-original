@extends('master')
@section('title', 'Editar Categoria')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('categorias-produtos.index') }}">Categorias</a>
    > {{ $categoria->getNome() }}
    > Editar
@stop
@section('search-url', route('categorias-produtos.index'))
@section('content')
    {!! Form::model($categoria, ['route' => ['categorias-produtos.update', $categoria->getId()], 'method' => 'PUT', 'class' => 'form-horizontal form-material', 'files' => true]) !!}
    @include('categorias-produtos.form-categoria-produtos')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop