@extends('master')
@section('title', 'Editar Souvenir')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('souvenirs.index') }}">Souvenirs</a>
    > <a href="{{ route('souvenirs.show', [$souvenir->getId()]) }}">{{ $souvenir->getNome() }}</a>
    > Editar
@stop
@section('search-url', route('souvenirs.index'))
@section('content')
    {!! Form::model($souvenir, ['route' => ['souvenirs.update', $souvenir->getId()], 'method' => 'PUT', 'class' => 'form-horizontal form-material', 'files' => true]) !!}
    @include('souvenirs.form-souvenir')
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop