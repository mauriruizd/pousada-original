@extends('master')
@section('title', 'Abrir Caixa')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('caixas.index') }}">Caixa</a>
    > Abrir
@stop
@section('search-url', route('caixas.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => 'caixas.abrir', 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    <div class="form-group">
        <label class="col-md-12">Quantia Inicial</label>
        <div class="col-md-12">
            {!! Form::number('quantidade_inicial', is_null($caixaAnterior) ? 1 : $caixaAnterior->valor_total, array_merge(['class' => 'form-control form-control-line', 'required', 'step' => '0.01', 'min' => 1], is_null($caixaAnterior) ? [] : ['readonly'])) !!}
        </div>
    </div>
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop