@extends('master')
@section('title', 'Editar Quarto')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('quartos.index') }}">Quartos</a>
    > <a href="{{ route('quartos.show', [$quarto->getId()]) }}">{{ $quarto->getNumero() }}</a>
    > Editar
@stop
@section('search-url', route('quartos.index'))
@section('content')
    {!! Form::open(['route' => ['quartos.update', $quarto->getId()], 'method' => 'PUT', 'class' => 'form-horizontal form-material', 'files' => true]) !!}
    @include('quartos.form-quarto')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop
@section('js')
    <script src="{{ url('js/quartos.js') }}"></script>
@stop
@section('css')
    <link rel="stylesheet" href="{{ url('css/datepicker.css') }}">
@stop