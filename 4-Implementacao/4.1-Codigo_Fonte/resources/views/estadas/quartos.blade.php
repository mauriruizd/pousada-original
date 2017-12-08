@extends('master')
@section('title', 'Alterar Quarto')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('estadas.index') }}">Estadas</a>
    > <a href="{{ route('estadas.show', [$estada->getId()]) }}">{{ $estada->getQuarto()->getNumero() }}</a>
    > Alterar Quarto
@stop
@section('search-url', route('estadas.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => ['estadas.update-quarto', $estada->getId()], 'method' => 'PUT', 'class' => 'form-horizontal form-material']) !!}
    <div class="row">
        <div class="col-md-12">
            @foreach($quartos as $tipoQuarto)
                <h4>{{ $tipoQuarto[0]->tipoQuarto->nome }}</h4>
                @foreach($tipoQuarto as $quarto)
                    <div class='row'>
                        <label>
                            <input id='quarto_{{ $quarto->getId() }}' type='radio' name='id_quarto' value='{{ $quarto->getId() }}' {{ $quarto->getId() == $estada->getQuarto()->getId() ? 'checked' : '' }}> {{ $quarto->getNumero() }}</label>
                    </div>
                @endforeach
            @endforeach

            <div class="floating-menu">
                <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
                    <i class="fa fa-check"></i>
                </button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop