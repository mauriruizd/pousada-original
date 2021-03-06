@extends('master')
@section('title', 'Detalhe de Quarto')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('quartos.index') }}">Quartos</a>
    > {{ $quarto->getNumero() }}
@stop
@section('search-url', route('quartos.index'))
@section('content')
    <div class="row">
        <label class="col-md-12">Número</label>
        <p class="col-md-12">
            {{ $quarto->getNumero() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Andar</label>
        <p class="col-md-12">
            {{ $quarto->getAndar() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Tipo de Quarto</label>
        <p class="col-md-12">
            {{ $quarto->getTipoQuarto()->getNome() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Fotos</label>
        <div class="row">
            @foreach($quarto->getFotos() as $foto)
                <div class="col-md-3">
                    <img src="{{ $foto->getUrl() }}" class="img-responsive">
                </div>
            @endforeach
        </div>
    </div>
    <div class="floating-menu">
        <div class="submenu">
            <a href="{{ route('quartos.promocao.create', [$quarto->getId()]) }}" class="btn btn-primary btn-rounded">
                <i class="fa fa-dollar"></i>
            </a>
            <a href="{{ route('quartos.manutencao.create', [$quarto->getId()]) }}" class="btn btn-primary btn-rounded">
                <i class="fa fa-wrench"></i>
            </a>
            <a href="{{ route('quartos.edit', [$quarto->getId()]) }}" class="btn btn-primary btn-rounded" title="Editar">
                <i class="fa fa-pencil"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop