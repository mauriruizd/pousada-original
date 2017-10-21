@extends('master')
@section('title', 'Criar Exceção de Preço')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('tipos-quartos.index') }}">Tipos de Quartos</a>
    > <a href="{{ route('tipos-quartos.show', [$tipoQuarto->getId()]) }}">{{ $tipoQuarto->getNome() }}</a>
    > <a href="{{ route('tipos-quartos.excecoes-precos.index', [$tipoQuarto->getId()]) }}">Excecões de Preço</a>
    > Nova
@stop
@section('search-url', route('tipos-quartos.excecoes-precos.index', [$tipoQuarto->getId()]))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => ['tipos-quartos.excecoes-precos.store', $tipoQuarto->getId()], 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    @include('tipos-quartos.excecoes-precos.form-excecao-preco')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop
@section('js')
    <script src="{{ url('js/excecoes-precos.js') }}"></script>
@stop
@section('css')
    <link rel="stylesheet" href="{{ url('css/datepicker.css') }}">
@stop