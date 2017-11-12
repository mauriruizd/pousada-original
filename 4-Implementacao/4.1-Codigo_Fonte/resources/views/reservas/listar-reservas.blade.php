@extends('master')
@section('title', 'Listagem de Reservas')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Reservas
@stop
@section('search-url', route('reservas.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Reservas encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $reservas->count() }} reservas.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Quarto</th>
                <th>Período</th>
                <th>Editar</th>
                <th>Arquivar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->getQuarto()->getNumero() }}</td>
                    <td>{{ $reserva->getDataEntrada() }} - {{ $reserva->getDataSaida() }}</td>
                    <td>
                        <a href="{{ route('reservas.show', [$reserva->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('reservas.edit', [$reserva->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                    <td>
                        {!! Form::open(['route' => ['reservas.destroy', $reserva->getId()], 'method' => 'delete']) !!}
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-archive"></i>
                        </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $reservas->render() !!}
    </div>
    <div class="floating-menu">
        <a href="{{ route('reservas.create') }}" class="btn btn-primary btn-rounded btn-lg menu-main" title="Criar nova reserva">
            <i class="fa fa-plus"></i>
        </a>
    </div>
@stop