@extends('master')
@section('title', 'Gerar Reserva')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('reservas.index') }}">Reservas</a>
    > Nova
@stop
@section('search-url', route('reservas.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => 'reservas.store', 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    @include('reservas.form-reserva')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop
@section('js')
    <script src="{{ url('js/reservas.js') }}"></script>
@stop
@section('css')
    <link rel="stylesheet" href="{{ url('css/datepicker.css') }}">
@stop