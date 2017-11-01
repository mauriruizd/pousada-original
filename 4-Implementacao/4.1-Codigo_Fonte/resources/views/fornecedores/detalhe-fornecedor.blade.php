@extends('master')
@section('title', 'Detalhe de Fornecedor')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('fornecedores.index') }}">Fornecedores</a>
    > {{ $fornecedor->getNome() }}
@stop
@section('search-url', route('fornecedores.index'))
@section('content')
    <div class="row">
        <label class="col-md-12">Nome</label>
        <div class="col-md-12">
            {{ $fornecedor->getNome() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">CPNJ</label>
        <div class="col-md-12">
            {{ $fornecedor->getCnpj() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">CEP</label>
        <div class="col-md-12">
            {{ $fornecedor->getCep() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Endereço</label>
        <div class="col-md-12">
            {{ $fornecedor->getEndereco() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Número</label>
        <div class="col-md-12">
            {{ $fornecedor->getNumero() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Complemento</label>
        <div class="col-md-12">
            {{ $fornecedor->getComplemento() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">País</label>
        <div class="col-md-12">
            {{ $fornecedor->getCidade()->getEstado()->getPais()->getNome() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Estado</label>
        <div class="col-md-12">
            {{ $fornecedor->getCidade()->getEstado()->getNome() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Cidade</label>
        <div class="col-md-12">
            {{ $fornecedor->getCidade()->getNome() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Fone</label>
        <div class="col-md-12">
            {{ $fornecedor->getFone() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">E-mail</label>
        <div class="col-md-12">
            {{ $fornecedor->getEmail() }}
        </div>
    </div>
    <div class="row">
        <label class="col-md-12">Site</label>
        <div class="col-md-12">
            {{ $fornecedor->getSite() }}
        </div>
    </div>

    <div class="row">
        <label class="col-md-12">Nome do Encarregado</label>
        <div class="col-md-12">
            {{ $fornecedor->getNomeEncarregado() }}
        </div>
    </div>
    <div class="floating-menu">
        <div class="submenu">
            {!! Form::open(['route' => ['fornecedores.destroy', $fornecedor->getId()], 'method' => 'delete']) !!}
                <button type="submit" class="btn btn-primary btn-rounded">
                    <i class="fa fa-archive"></i>
                </button>
            {!! Form::close() !!}
            <a href="{{ route('fornecedores.edit', [$fornecedor->getId()]) }}" class="btn btn-primary btn-rounded">
                <i class="fa fa-pencil"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop