@extends('master')
@section('title', 'Editar Fonte')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('fontes-reservas.index') }}">Fontes</a>
    > {{ $fonte->getNome() }}
    > Editar
@stop
@section('search-url', route('fontes-reservas.index'))
@section('content')
    {!! Form::model($fonte, ['route' => ['fontes-reservas.update', $fonte->getId()], 'method' => 'PUT', 'class' => 'form-horizontal form-material']) !!}
    @include('fontes-reservas.form-fonte-reservas')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop