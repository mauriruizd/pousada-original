@extends('master')
@section('title', 'Detalhe de Cliente')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('clientes.index') }}">Clientes</a>
    > {{ $cliente->getNome() }}
@stop
@section('search-url', route('clientes.index'))
@section('content')
    <div class="row">
        <label class="col-md-12">Nome</label>
        <p class="col-md-12">
            {{ $cliente->getNome() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">E-mail</label>
        <p class="col-md-12">
            {{ $cliente->getEmail() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Telefone</label>
        <p class="col-md-12">
            {{ $cliente->getTelefone() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Celular</label>
        <p class="col-md-12">
            {{ $cliente->getCelular() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Profissão</label>
        <p class="col-md-12">
            {{ $cliente->getProfissao() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Nacionalidae</label>
        <p class="col-md-12">
            {{ $cliente->getNacionalidade()->getNome() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Data de Nascimento</label>
        <p class="col-md-12">
            {{ $cliente->getDataNascimento()->format('d/m/Y') }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Documento de Identidade</label>
        <p class="col-md-12">
            {{ $cliente->getDni() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">CPF</label>
        <p class="col-md-12">
            {{ $cliente->getCpf() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Gênero</label>
        <p class="col-md-12">
            @if($cliente->getGenero() === \App\Entities\Enumeration\Genero::$FEMININO)
                Feminino
            @else
                Masculino
            @endif
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Endereço</label>
        <p class="col-md-12">
            {{ $cliente->getEndereco() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">País de Residência</label>
        <p class="col-md-12">
            {{ $cliente->getCidade()->getEstado()->getPais()->getNome() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Estado</label>
        <p class="col-md-12">
            {{ $cliente->getCidade()->getEstado()->getNome() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Cidade</label>
        <p class="col-md-12">
            {{ $cliente->getCidade()->getNome() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Telefone</label>
        <p class="col-md-12">
            {{ $cliente->getTelefone() }}
        </p>
    </div>
    <div class="row">
        <label class="col-md-12">Observaçoes</label>
        <p class="col-md-12">
            {{ nl2br($cliente->getObservacoes()) }}
        </p>
    </div>
    <div class="floating-menu">
        <div class="submenu">
            <a href="{{ route('clientes.ficha', [$cliente->getId()]) }}" class="btn btn-primary btn-rounded">
                <i class="fa fa-print"></i>
            </a>
            {!! Form::open(['route' => ['clientes.destroy', $cliente->getId()], 'method' => 'delete']) !!}
                <button type="submit" class="btn btn-primary btn-rounded">
                    <i class="fa fa-times"></i>
                </button>
            {!! Form::close() !!}
            <a href="{{ route('clientes.edit', [$cliente->getId()]) }}" class="btn btn-primary btn-rounded">
                <i class="fa fa-pencil"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop