@extends('master')
@section('title', 'Listado de Tipos de Quartos')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Tipos de Quartos
@stop
@section('search-url', route('tipos-quartos.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Tipos de quartos encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $tiposQuartos->total() }} Tipos de Quartos.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Tipo de Quarto</th>
                <th>Tabela de preços</th>
                <th>Iniciar/Alterar promoção</th>
                <th>Finalizar promoção</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tiposQuartos as $tipoQuarto)
                <tr>
                    <td>{{ $tipoQuarto->getNome() }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('tipos-quartos.tarifas.show', [$tipoQuarto->getId()]) }}">
                            <i class="fa fa-table"></i>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('tipos-quartos.promocao.' . ($tipoQuarto->getPrecoPromocional() === null ? 'create' : 'edit'), [$tipoQuarto->getId()]) }}">
                            <i class="fa fa-thumbs-o-up"></i>
                        </a>
                    </td>
                    <td>
                        {!! Form::open(['route' => ['tipos-quartos.promocao.delete', $tipoQuarto->getId()], 'method' => 'delete']) !!}
                            <button type="submit" class="btn btn-primary" {!! $tipoQuarto->getPrecoPromocional() === null ? 'disabled' : '' !!}>
                                <i class="fa fa-thumbs-o-down"></i>
                            </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $tiposQuartos->render() !!}
    </div>
@stop