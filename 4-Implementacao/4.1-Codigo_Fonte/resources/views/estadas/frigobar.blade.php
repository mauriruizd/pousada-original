@extends('master')
@section('title', 'Realizar Checkin')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('estadas.index') }}">Estadas</a>
    > Registrar Consumo do Frigobar
@stop
@section('search-url', route('reservas.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::hidden('consultar-estoque-endpoint', route('produtos.consultar-estoque'), ['id' => 'consultar-estoque-endpoint']) !!}
    {!! Form::open(['route' => ['estadas.store-frigobar', $estada->getId()], 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    <div class="row" style="padding-bottom: 10px;">
        <div class="col-md-12">
            {!! Form::label('id_produto', 'Produto') !!}
        </div>
        {!! Form::select('id_produto', $produtos, null, ['class' => 'form-control selectpicker', 'data-live-search' => 'true', 'id' => 'produto-select']) !!}
    </div>
    <div class="form-group">
        <label class="col-md-12">Quantidade</label>
        <div class="col-md-12">
            {!! Form::number('quantidade', 1, ['class' => 'form-control form-control-line', 'required', 'min' => 1, 'id' => 'quantidade']) !!}
        </div>
    </div>
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop
@section('js')
    <script src="{{ url('js/frigobar.js') }}"></script>
    <script src="{{ url('js/bootstrap-select.min.js') }}"></script>
    {{--<script src="{{ url('js/defaults-pt_BR.min.js') }}"></script>--}}
@stop
@section('css')
    <link rel="stylesheet" href="{{ url('css/datepicker.css') }}">
    <link rel="stylesheet" href="{{ url('css/bootstrap-select.min.css') }}">
@stop