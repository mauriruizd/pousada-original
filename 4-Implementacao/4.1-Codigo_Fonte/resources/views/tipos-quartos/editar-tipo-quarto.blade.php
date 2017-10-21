@extends('master')
@section('title', 'Editar Cliente')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('tipos-quartos.index') }}">Tipos de Quartos</a>
    > <a href="{{ route('tipos-quartos.show', [$tipoQuarto->getId()]) }}">{{ $tipoQuarto->getNome() }}</a>
    > Editar
@stop
@section('search-url', route('tipos-quartos.index'))
@section('content')
    {!! Form::model($tipoQuarto, ['route' => ['tipos-quartos.update', $tipoQuarto->getId()], 'method' => 'PUT', 'class' => 'form-horizontal form-material']) !!}
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