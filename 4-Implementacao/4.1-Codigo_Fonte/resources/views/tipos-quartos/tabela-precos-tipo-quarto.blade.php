@extends('master')
@section('title', 'Listado de Tipos de Quartos')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('tipos-quartos.index') }}">Tipos de Quartos</a>
    > {{ $tipoQuarto->getNome() }}
    > Tabela de preços
@stop
@section('content')
    {!! Form::open(['route' => ['tipos-quartos.tarifas.update', $tipoQuarto->getId()], 'method' => 'put']) !!}
    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th>Mês</th>
                <th>Preço da diária</th>
            </tr>
            </thead>
            <tbody>
            @foreach($meses as $i => $mes)
                <tr>
                    <td>{{ $mes }}</td>
                    <td>
                        {!! Form::number('precos[' . ($i + 1) . ']', $tipoQuarto->getTarifa($i + 1) === null ? 0 : $tipoQuarto->getTarifa($i + 1)->getPreco(), ['class' => 'form-control', 'min' => '0', 'step' => 'any']) !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop