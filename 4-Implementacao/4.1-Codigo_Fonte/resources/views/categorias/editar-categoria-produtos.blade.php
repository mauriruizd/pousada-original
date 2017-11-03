@extends('master')
@section('title', 'Editar Categoria')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('categorias.index') }}">Categorias</a>
    > <a href="{{ route('categorias.show', [$categoria->getId()]) }}">{{ $categoria->getNome() }}</a>
    > Editar
@stop
@section('search-url', route('categorias.index'))
@section('content')
    {!! Form::model($categoria, ['route' => ['categorias.update', $categoria->getId()], 'method' => 'PUT', 'class' => 'form-horizontal form-material', 'files' => true]) !!}
    @include('categorias.form-categoria-produtos')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop