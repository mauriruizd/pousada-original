@extends('master')
@section('title', 'Editar Categoria')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('categorias-comissionistas.index') }}">Categorias</a>
    > {{ $categoria->getNome() }}
    > Editar
@stop
@section('search-url', route('categorias-comissionistas.index'))
@section('content')
    {!! Form::model($categoria, ['route' => ['categorias-comissionistas.update', $categoria->getId()], 'method' => 'PUT', 'class' => 'form-horizontal form-material', 'files' => true]) !!}
    @include('categorias-comissionistas.form-categoria-comissionistas')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop