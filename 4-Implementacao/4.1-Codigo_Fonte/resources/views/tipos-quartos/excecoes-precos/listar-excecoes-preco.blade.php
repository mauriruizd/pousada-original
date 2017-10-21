@extends('master')
@section('title', 'Listado de Tipos de Quartos')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('tipos-quartos.index') }}">Tipos de Quartos</a>
    > <a href="{{ route('tipos-quartos.show', [$tipoQuarto->getId()]) }}">{{ $tipoQuarto->getNome() }}</a>
    > Excecões de Preço
@stop
@section('search-url', route('tipos-quartos.excecoes-precos.index', [$tipoQuarto->getId()]))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Exceções encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $excecoes->total() }} Exceções.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Preço de Exceção</th>
                <th>Data Início</th>
                <th>Data de Finalização</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($excecoes as $excecao)
                <tr>
                    <td>{{ $excecao->getPreco() }}</td>
                    <td>{{ $excecao->getDataInicio() }}</td>
                    <td>{{ $excecao->getDataFim() }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('tipos-quartos.excecoes-precos.edit', [$tipoQuarto->getId(), $excecao->getId()]) }}">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                    <td>
                        {!! Form::open(['route' => ['tipos-quartos.excecoes-precos.destroy', $tipoQuarto->getId(), $excecao->getId()], 'method' => 'delete']) !!}
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-times"></i>
                            </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $excecoes->render() !!}
    </div>
    <div class="floating-menu">
        <a href="{{ route('tipos-quartos.excecoes-precos.create', [$tipoQuarto->getId()]) }}" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-plus"></i>
        </a>
    </div>
@stop