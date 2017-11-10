@extends('master')
@section('title', 'Criar Comissionista')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('comissionistas.index') }}">Comissionistas</a>
    > Novo
@stop
@section('search-url', route('comissionistas.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => 'comissionistas.store', 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    @include('comissionistas.form-comissionista')
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