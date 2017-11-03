@extends('master')
@section('title', 'Listagem de Produtos')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Produtos
@stop
@section('search-url', route('produtos.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Produtos encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $produtos->count() }} produtos.</h4>
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
                @foreach($produtos as $produto)
                    <tr>
                        <td>{{ $produto->getNome() }}</td>
                        <td>
                            <a href="{{ route('produtos.show', [$produto->getId()]) }}" class="btn btn-primary">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('produtos.edit', [$produto->getId()]) }}" class="btn btn-primary">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                        <td>
                            {!! Form::open(['route' => ['produtos.destroy', $produto->getId()], 'method' => 'delete']) !!}
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-archive"></i>
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        {!! $produtos->render() !!}
    </div>
    <div class="floating-menu">
        <div class="submenu">
            <a href="{{ route('produtos.listagem') }}" class="btn btn-primary btn-rounded" title="Listagem de produtos">
                <i class="fa fa-file-text-o"></i>
            </a>
            <a href="{{ route('produtos.relatorios.entrada') }}" class="btn btn-primary btn-rounded" title="Relatório de entrada">
                <i class="fa fa-list-alt"></i>
            </a>
            <a href="{{ route('produtos.relatorios.saida') }}" class="btn btn-primary btn-rounded" title="Relatório de saída">
                <i class="fa fa-list-alt"></i>
            </a>
            <a href="{{ route('produtos.relatorios.estoque') }}" class="btn btn-primary btn-rounded" title="Relatório de estoque">
                <i class="fa fa-list-alt"></i>
            </a>
            <a href="{{ route('produtos.arquivados') }}" class="btn btn-primary btn-rounded" title="Listar produtos arquivados">
                <i class="fa fa-archive"></i>
            </a>
            <a href="{{ route('produtos.create') }}" class="btn btn-rounded btn-primary" title="Criar novo registro de produto">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop