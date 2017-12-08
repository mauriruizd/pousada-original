@extends('master')
@section('title', 'Editar Reserva')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('reservas.index') }}">Reservas</a>
    > <a href="{{ route('reservas.show', [$reserva->getId()]) }}">{{ $reserva->getQuarto()->getNumero() }} ({{ $reserva->getDataEntrada() }} - {{ $reserva->getDataSaida() }})</a>
    > Editar
@stop
@section('search-url', route('reservas.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => ['reservas.update', $reserva->getId()], 'method' => 'PUT', 'class' => 'form-horizontal form-material']) !!}
    @include('reservas.form-reserva')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop
@section('js')
    <script>
        const savedNumeroQuarto = {{ $reserva->getQuarto()->getId() }};
        const reservaId = {{ $reserva->getId() }};
    </script>
    <script src="{{ url('js/reservas.js') }}"></script>
    <script src="{{ url('js/bootstrap-select.min.js') }}"></script>
    {{--<script src="{{ url('js/defaults-pt_BR.min.js') }}"></script>--}}
@stop
@section('css')
    <link rel="stylesheet" href="{{ url('css/datepicker.css') }}">
    <link rel="stylesheet" href="{{ url('css/bootstrap-select.min.css') }}">
@stop