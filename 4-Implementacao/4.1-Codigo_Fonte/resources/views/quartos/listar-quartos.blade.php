@extends('master')
@section('title', 'Listado de Quartos')
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
        </div>
        <a href="{{ route('quartos.create') }}" class="btn btn-rounded btn-lg btn-primary">
            <i class="fa fa-plus"></i>
        </a>
    </div>
@stop