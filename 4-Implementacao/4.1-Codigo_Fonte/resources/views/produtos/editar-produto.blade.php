@extends('master')
@section('title', 'Editar Produto')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('produtos.index') }}">Produtos</a>
    > <a href="{{ route('produtos.show', [$produto->getId()]) }}">{{ $produto->getNome() }}</a>
    > Editar
@stop
@section('search-url', route('produtos.index'))
@section('content')
    {!! Form::model($produto, ['route' => ['produtos.update', $produto->getId()], 'method' => 'PUT', 'class' => 'form-horizontal form-material', 'files' => true]) !!}
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