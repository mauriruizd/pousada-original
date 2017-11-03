@extends('master')
@section('title', 'Detalhe de Produto')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('produtos.index') }}">Produtos</a>
    > {{ $produto->getNome() }}
@stop
@section('search-url', route('produtos.index'))
@section('content')
    <div class="row">
        <label class="col-md-12">Nome</label>
        <div class="col-md-12">
            {{ $produto->getNome() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Categoria</label>
        <div class="col-md-12">
            {{ $produto->getCategoria()->getNome() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Fornecedor</label>
        <div class="col-md-12">
            {{ $produto->getFornecedor()->getNome() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Estoque</label>
        <div class="col-md-12">
            {{ $produto->getEstoque() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Estoque Mínimo</label>
        <div class="col-md-12">
            {{ $produto->getEstoqueMinimo() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Estoque Inicial</label>
        <div class="col-md-12">
            {{ $produto->getEstoqueInicial() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Preço de venda</label>
        <div class="col-md-12">
            {{ $produto->getPrecos()->sortByDesc('datahora_cadastro')->first()->preco }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Foto</label>
        <div class="col-md-12">
            @if(!empty($produto->getImagenUrl()))
                <div class="col-md-4">
                    <img src="{{ $produto->getImagenUrl() }}" alt="{{ $produto->getNome() }}" class="img-responsive">
                </div>
            @endif
        </div>
    </div>
    <div class="floating-menu">
        <div class="submenu">
            {!! Form::open(['route' => ['produtos.destroy', $produto->getId()], 'method' => 'delete']) !!}
                <button type="submit" class="btn btn-primary btn-rounded">
                    <i class="fa fa-archive"></i>
                </button>
            {!! Form::close() !!}
            <a href="{{ route('produtos.edit', [$produto->getId()]) }}" class="btn btn-primary btn-rounded">
                <i class="fa fa-pencil"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop