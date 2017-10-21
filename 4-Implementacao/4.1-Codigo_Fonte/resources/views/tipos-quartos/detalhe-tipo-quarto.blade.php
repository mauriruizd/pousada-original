@extends('master')
@section('title', 'Criar Tipo de Quarto')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('tipos-quartos.index') }}">Tipos de Quarto</a>
    > {{ $tipoQuarto->getNome() }}
@stop
@section('search-url', route('clientes.index'))
@section('content')
    <div class="row">
        <label class="col-md-12">Nome</label>
        <p class="col-md-12">
            {{ $tipoQuarto->getNome() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Capacidade</label>
        <p class="col-md-12">
            {{ $tipoQuarto->getCapacidade() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Preço</label>
        <p class="col-md-12">
            {{ $tipoQuarto->getPreco() }}
        </p>
    </div>
    <div class="floating-menu">
        <div class="submenu">
            {!! Form::open(['route' => ['tipos-quartos.destroy', $tipoQuarto->getId()], 'method' => 'delete']) !!}
                <button type="submit" class="btn btn-primary btn-rounded">
                    <i class="fa fa-archive"></i>
                </button>
            {!! Form::close() !!}
            <a href="{{ route('tipos-quartos.edit', [$tipoQuarto->getId()]) }}" class="btn btn-primary btn-rounded">
                <i class="fa fa-pencil"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop