@extends('master')
@section('title', 'Editar Comissionista')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('comissionistas.index') }}">Comissionistas</a>
    > <a href="{{ route('comissionistas.show', [$comissionista->getId()]) }}">{{ $comissionista->getNome() }}</a>
    > Editar
@stop
@section('search-url', route('comissionistas.index'))
@section('content')
    {!! Form::model($comissionista, ['route' => ['comissionistas.update', $comissionista->getId()], 'method' => 'PUT', 'class' => 'form-horizontal form-material']) !!}
    @include('comissionistas.form-comissionista')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop