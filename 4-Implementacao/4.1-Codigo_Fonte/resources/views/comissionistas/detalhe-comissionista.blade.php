@extends('master')
@section('title', 'Detalhe de  Comissionista')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('comissionistas.index') }}">Comissionistas</a>
    > {{ $comissionista->getNome() }}
@stop
@section('search-url', route('comissionistas.index'))
@section('content')
    <div class="row">
        <label class="col-md-12">Nome</label>
        <div class="col-md-12">
            {{ $comissionista->getNome() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Telefone</label>
        <div class="col-md-12">
            {{ $comissionista->getTelefone() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Categoria</label>
        <div class="col-md-12">
            {{ $comissionista->getCategoria()->getNome() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Percentagem</label>
        <div class="col-md-12">
            R$ {{ $comissionista->getPercentagem() }}
        </div>
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="{{ url('css/datepicker.css') }}">
@stop