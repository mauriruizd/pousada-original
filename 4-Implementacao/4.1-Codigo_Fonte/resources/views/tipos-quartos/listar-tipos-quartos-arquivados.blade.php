@extends('master')
@section('title', 'Listado de Tipos de Quartos Arquivados')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('tipos-quartos.index') }}">Tipos de Quartos</a>
    > Arquivados
@stop
@section('search-url', route('tipos-quartos.arquivados'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Tipos de quartos encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $tiposQuartos->total() }} Tipos de Quartos arquivados.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Tipo de Quarto</th>
                <th>Recuperar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tiposQuartos as $tipoQuarto)
                <tr>
                    <td>{{ $tipoQuarto->getNome() }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('tipos-quartos.recuperar', [$tipoQuarto->getId()]) }}">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $tiposQuartos->render() !!}
    </div>
    <div class="floating-menu">
        <a href="{{ route('tipos-quartos.index') }}" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-arrow-circle-o-left"></i>
        </a>
    </div>
@stop