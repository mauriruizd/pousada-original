@extends('master')
@section('title', 'Listagem de Quartos')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Quartos
@stop
@section('search-url', route('quartos.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Quartos encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $quartos->total() }} quartos.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Numero de Quarto</th>
                <th>Andar</th>
                <th>Tipo de Quarto</th>
                <th>Detalhes</th>
                <th>Editar</th>
                <th>Manutenção</th>
                <th>Arquivar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($quartos as $quarto)
                <tr>
                    <td>{{ $quarto->getNumero() }}</td>
                    <td>{{ $quarto->getAndar() }}</td>
                    <td>{{ $quarto->getTipoQuarto()->getNome() }}</td>
                    <td>
                        <a href="{{ route('quartos.show', [$quarto->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('quartos.edit', [$quarto->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                    <td>
                        @if($quarto->getEmManutencao())
                            {!! Form::open(['route' => ['quartos.manutencao.destroy', $quarto->getId()], 'method' => 'delete']) !!}
                            <button type="submit" class="btn btn-primary">
                                Terminar
                            </button>
                            {!! Form::close() !!}
                        @else
                            <a href="{{ route('quartos.manutencao.create', [$quarto->getId()]) }}" class="btn btn-primary">
                                Iniciar
                            </a>
                        @endif
                    </td>
                    <td>
                        {!! Form::open(['route' => ['quartos.destroy', $quarto->getId()], 'method' => 'delete']) !!}
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-archive"></i>
                        </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $quartos->render() !!}
    </div>
    <div class="floating-menu">
        <div class="submenu">
            <a href="{{ route('quartos.index', ['disponibilidade' => '']) }}" class="btn btn-primary btn-rounded">
                <i class="fa fa-calendar"></i>
            </a>
            <a href="{{ route('quartos.arquivados') }}" class="btn btn-primary btn-rounded" title="Listar quartos arquivados">
                <i class="fa fa-archive"></i>
            </a>
            <a href="{{ route('quartos.create') }}" class="btn btn-rounded btn-primary" title="Criar novo registro de quarto">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop