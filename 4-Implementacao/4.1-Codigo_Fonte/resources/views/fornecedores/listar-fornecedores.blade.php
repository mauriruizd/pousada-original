@extends('master')
@section('title', 'Listado de Fornecedores')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Fornecedores
@stop
@section('search-url', route('fornecedores.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Fornecedores encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $fornecedores->count() }} fornecedores.</h4>
            <table class="table">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Detalhes</th>
                    <th>Editar</th>
                    <th>Arquivar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($fornecedores as $fornecedor)
                    <tr>
                        <td>{{ $fornecedor->getNome() }}</td>
                        <td>
                            <a href="{{ route('fornecedores.show', [$fornecedor->getId()]) }}" class="btn btn-primary">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('fornecedores.edit', [$fornecedor->getId()]) }}" class="btn btn-primary">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                        <td>
                            {!! Form::open(['route' => ['fornecedores.destroy', $fornecedor->getId()], 'method' => 'delete']) !!}
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-archive"></i>
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        {!! $fornecedores->render() !!}
    </div>
    <div class="floating-menu">
        <div class="submenu">
            <a href="{{ route('fornecedores.relatorio') }}" class="btn btn-primary btn-rounded" title="Gerar relatório de compras">
                <i class="fa fa-shopping-cart"></i>
            </a>
            <a href="{{ route('fornecedores.arquivados') }}" class="btn btn-primary btn-rounded" title="Listar fornecedores arquivados">
                <i class="fa fa-archive"></i>
            </a>
            <a href="{{ route('fornecedores.create') }}" class="btn btn-rounded btn-primary" title="Criar novo registro de fornecedor">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop