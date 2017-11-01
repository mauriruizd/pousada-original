@extends('master')
@section('title', 'Criar Fornecedor')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('fornecedores.index') }}">Fornecedores</a>
    > Novo
@stop
@section('search-url', route('fornecedores.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => 'fornecedores.store', 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    @include('fornecedores.form-fornecedor')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop
@section('js')
    <script src="{{ url('js/fornecedores.js') }}"></script>
@stop
@section('css')
    <link rel="stylesheet" href="{{ url('css/datepicker.css') }}">
@stop