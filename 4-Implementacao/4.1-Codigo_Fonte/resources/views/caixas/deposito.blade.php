@extends('master')
@section('title', 'Registrar Deposito')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('caixas.index') }}">Caixa</a>
    > Registrar Deposito
@stop
@section('search-url', route('caixas.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => 'caixas.deposito', 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    @include('caixas.form-movimento')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop
