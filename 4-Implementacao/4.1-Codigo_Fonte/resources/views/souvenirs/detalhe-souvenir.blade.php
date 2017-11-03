@extends('master')
@section('title', 'Detalhe de Souvenir')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('souvenirs.index') }}">Souvenirs</a>
    > {{ $souvenir->getNome() }}
@stop
@section('search-url', route('souvenirs.index'))
@section('content')
    <div class="row">
        <label class="col-md-12">Nome</label>
        <div class="col-md-12">
            {{ $souvenir->getNome() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Preço</label>
        <div class="col-md-12">
            {{ $souvenir->getPreco() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Foto</label>
        <div class="col-md-12">
            @if(!empty($souvenir->getImagemUrl()))
                <div class="col-md-4">
                    <img src="{{ $souvenir->getImagemUrl() }}" alt="{{ $souvenir->getNome() }}" class="img-responsive">
                </div>
            @endif
        </div>
    </div>
    <div class="floating-menu">
        <div class="submenu">
            {!! Form::open(['route' => ['souvenirs.destroy', $souvenir->getId()], 'method' => 'delete']) !!}
                <button type="submit" class="btn btn-primary btn-rounded">
                    <i class="fa fa-archive"></i>
                </button>
            {!! Form::close() !!}
            <a href="{{ route('souvenirs.edit', [$souvenir->getId()]) }}" class="btn btn-primary btn-rounded">
                <i class="fa fa-pencil"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop