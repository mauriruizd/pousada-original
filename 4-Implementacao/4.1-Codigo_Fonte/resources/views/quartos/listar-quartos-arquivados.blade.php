@extends('master')
@section('title', 'Listagem de Quartos Arquivados')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('quartos.index') }}">Quartos</a>
    > Arquivados
@stop
@section('search-url', route('quartos.arquivados'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Quartos encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $quartos->total() }} Quartos arquivados.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Número de Quarto</th>
                <th>Recuperar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($quartos as $quarto)
                <tr>
                    <td>{{ $quarto->getNumero() }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('quartos.recuperar', [$quarto->getId()]) }}">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $quartos->render() !!}
    </div>
    <div class="floating-menu">
        <a href="{{ route('quartos.index') }}" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-arrow-circle-o-left"></i>
        </a>
    </div>
@stop