@extends('master')
@section('title', 'Criar Produto')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('produtos.index') }}">Produtos</a>
    > Novo
@stop
@section('search-url', route('produtos.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => 'produtos.store', 'method' => 'POST', 'class' => 'form-horizontal form-material', 'files' => true]) !!}
    @include('produtos.form-produto')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop
@section('js')
    <script src="{{ url('js/produtos.js') }}"></script>
@stop
@section('css')
    <link rel="stylesheet" href="{{ url('css/datepicker.css') }}">
@stop