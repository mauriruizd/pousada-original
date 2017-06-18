@extends('master')
@section('title', 'Criar Cliente')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('clientes.index') }}">Clientes</a>
    > Novo
@stop
@section('search-url', route('clientes.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => 'clientes.store', 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    @include('clientes.form-cliente')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop
@section('js')
    <script src="{{ url('js/clientes.js') }}"></script>
@stop
@section('css')
    <link rel="stylesheet" href="{{ url('css/datepicker.css') }}">
@stop