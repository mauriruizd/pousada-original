@extends('master')
@section('title', 'Iniciar Promoção de Tipo de Quarto')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('tipos-quartos.index') }}">Tipos de Quartos</a>
    > {{ $tipoQuarto->getNome() }}
    > Iniciar Promoção
@stop
@section('content')
    {!! Form::open(['route' => ['tipos-quartos.promocao.store', $tipoQuarto->getId()], 'method' => 'post', 'class' => 'form-horizontal form-material']) !!}
    @include('tipos-quartos.form-promocao-tipo-quarto')
    {!! Form::close() !!}
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop