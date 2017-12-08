@extends('master')
@section('title', 'Registrar Dano')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('estadas.index') }}">Estadas</a>
    > <a href="{{ route('estadas.estado-conta', [$estada->getId()]) }}">Registrar Dano</a>
    > Registrar Dano
@stop
@section('search-url', route('reservas.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => ['estadas.store-dano', $estada->getId()], 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    <div class="form-group">
        <label class="col-md-12">Valor</label>
        <div class="col-md-12">
            {!! Form::number('valor', null, ['class' => 'form-control form-control-line', 'required', 'min' => 1, 'step' => '0.01']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12">Descrição</label>
        <div class="col-md-12">
            {!! Form::textarea('descricao', null, ['class' => 'form-control form-control-line', 'required']) !!}
        </div>
    </div>
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop