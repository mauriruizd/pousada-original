@extends('master')
@section('title', 'Registrar Pagamento')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('estadas.index') }}">Estadas</a>
    > <a href="{{ route('estadas.estado-conta', [$estada->getId()]) }}">Estado da Conta</a>
    > Registrar Pagamento
@stop
@section('search-url', route('reservas.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => ['estadas.store-pagamento', $estada->getId()], 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    <div class="form-group">
        <label class="col-md-12">Quantia</label>
        <div class="col-md-12">
            {!! Form::number('valor', $estada->getSaldo(), ['class' => 'form-control form-control-line', 'required', 'min' => 1, 'max' => $estada->getSaldo(), 'id' => 'quantidade']) !!}
        </div>
    </div>
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop