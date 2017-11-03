@extends('master')
@section('title', 'Criar Souvenir')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('souvenirs.index') }}">Souvenirs</a>
    > Novo
@stop
@section('search-url', route('souvenirs.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => 'souvenirs.store', 'method' => 'POST', 'class' => 'form-horizontal form-material', 'files' => true]) !!}
    @include('souvenirs.form-souvenir')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop