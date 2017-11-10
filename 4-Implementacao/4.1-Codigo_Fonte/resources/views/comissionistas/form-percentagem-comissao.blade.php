@extends('master')
@section('title', 'Modificar Percentagem de Comissão de Comissionista')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('comissionistas.index') }}">Comissionistas</a>
    > <a href="{{ route('comissionistas.show', [$comissionista->getId()]) }}">{{ $comissionista->getNome() }}</a>
    > Modificar Percentagem de Comissão
@stop
@section('search-url', route('comissionistas.index'))
@section('content')
    {!! Form::model($comissionista, ['route' => ['comissionistas.modificar-percentagem', $comissionista->getId()], 'method' => 'PUT', 'class' => 'form-horizontal form-material']) !!}
    <div class="form-group">
        <label class="col-md-12">Percentagem</label>
        <div class="col-md-12">
            {!! Form::number('percentagem', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira a percentagem', 'required', 'min' => 0, 'step' => 0.5, 'max' => 4294967295]) !!}
        </div>
    </div>
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop