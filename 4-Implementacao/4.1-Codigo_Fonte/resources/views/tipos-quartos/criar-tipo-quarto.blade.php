@extends('master')


@section('search-url', route('tipos-quartos.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => 'tipos-quartos.store', 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    @include('tipos-quartos.form-tipo-quarto')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop
@section('css')
    <link rel="stylesheet" href="{{ url('css/datepicker.css') }}">
@stop