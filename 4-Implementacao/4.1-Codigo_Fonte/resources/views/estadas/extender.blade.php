@extends('master')
@section('title', 'Extender Estada')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('estadas.index') }}">Estadas</a>
    > Extender Estada
@stop
@section('search-url', route('reservas.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => ['estadas.store-extender', $estada->getId()], 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    <div class="form-group">
        <label class="col-md-12">Quantidade de Diarias</label>
        <div class="col-md-12">
            {!! Form::number('diarias', 1, array_merge(['class' => 'form-control form-control-line', 'required', 'min' => 1, 'id' => 'quantidade'], $estada->getReservaProximaDias() > 1 ? ['max' => $estada->getReservaProximaDias()] : [])) !!}
        </div>
    </div>
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop