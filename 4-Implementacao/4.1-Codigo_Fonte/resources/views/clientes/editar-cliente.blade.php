@extends('master')
@section('title', 'Editar Cliente')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('clientes.index') }}">Clientes</a>
    > <a href="{{ route('clientes.show', [$cliente->getId()]) }}">{{ $cliente->getNome() }}</a>
    > Editar
@stop
@section('search-url', route('clientes.index'))
@section('content')
    {!! Form::open(['route' => ['clientes.update', $cliente->getId()], 'method' => 'PUT', 'class' => 'form-horizontal form-material']) !!}
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