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
                <th>Estado</th>
                <th>Detalhes</th>
                <th>Editar</th>
                <th>Consultar Saldo</th>
                <th>Consultar Pagam. de Comissão</th>
                <th>Cancelar</th>
                <th>Realizar Checkin</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->getQuarto()->getNumero() }}</td>
                    <td>{{ $reserva->getDataEntrada() }} - {{ $reserva->getDataSaida() }}</td>
                    <td>
                        @if($reserva->getEstado() == \App\Entities\Enumeration\EstadoReserva::$ABERTA)
                            <span class="text-warning">
                                Aberta
                            </span>
                        @elseif($reserva->getEstado() == \App\Entities\Enumeration\EstadoReserva::$CONFIRMADA)
                            <span class="text-success">
                                Confirmada
                                <i class="fa fa-check"></i>
                            </span>
                        @else
                            <span class="text-danger">
                                Cancelada
                                <i class="fa fa-times"></i>
                            </span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('reservas.show', [$reserva->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('reservas.edit', [$reserva->getId()]) }}" class="btn btn-primary" {{ ($reserva->getEstado() != \App\Entities\Enumeration\EstadoReserva::$CANCELADA && is_null($reserva->estada)) ? '' : 'disabled' }}>
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('reservas.saldo', [$reserva->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-question"></i>
                        </a>
                    </td>
                    <td>
                        @if(!is_null($reserva->getComissionista()))
                            <a href="{{ route('reservas.estado-comissao', [$reserva->getId()]) }}" class="btn btn-primary">
                                <i class="fa fa-dollar"></i>
                            </a>
                        @else
                            <i>Sem comissionista</i>
                        @endif
                    </td>
                    <td>
                        @if(auth()->user()->caixaAberto() == null)
                            <i class="text-danger">Não existe caixa aberto.</i>
                        @else
                            {!! Form::open(['route' => ['reservas.destroy', $reserva->getId()], 'method' => 'delete', 'onsubmit' => 'return confirm("Confirma a cancelação?")']) !!}
                            <button type="submit" class="btn btn-primary" {{ ($reserva->getEstado() != \App\Entities\Enumeration\EstadoReserva::$CANCELADA && is_null($reserva->estada)) ? '' : 'disabled' }}>
                                <i class="fa fa-times"></i>
                            </button>
                            {!! Form::close() !!}
                        @endif
                    </td>
                    <td>
                        @if(auth()->user()->caixaAberto() == null)
                            <i class="text-danger">Não existe caixa aberto.</i>
                        @else
                            @if(!is_null($reserva->estada))
                                <i>Checkin realizado</i>
                            @elseif($reserva->getEstado() == \App\Entities\Enumeration\EstadoReserva::$CANCELADA)
                                <i>Reserva cancelada</i>
                            @else
                                @if($reserva->checkCheckinDisponivel())
                                    <a href="{{ route('estadas.checkin-form', [$reserva->getId()]) }}" class="btn btn-primary">Realizar Checkin</a>
                                @else
                                    <i>Checkin ficará disponível no día {{ $reserva->getDataEntrada() }}</i>
                                @endif
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $reservas->render() !!}
    </div>
    <div class="floating-menu">
        <div class="submenu">
            <a href="{{ route('reservas.relatorio') }}" class="btn btn-primary btn-rounded" title="Relatório de reservas">
                <i class="fa fa-list"></i>
            </a>
            <a href="{{ route('reservas.create') }}" class="btn btn-primary btn-rounded" title="Criar nova reserva">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <button class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-bars"></i>
        </button>
    </div>
@stop