@extends('master')
@section('title', 'Relatório de reservas')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('reservas.index') }}">Reservas</a>
    > Relatório de reservas
@stop
@section('search-url', route('reservas.index'))
@section('content')
    <div class="row no-print">
        {!! Form::open(['route' => 'reservas.relatorio', 'method' => 'get']) !!}
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-12">Data de Inicio</label>
                <div class="col-md-12">
                    {!! Form::text('data_inicio', $dataInicio, ['class' => 'form-control form-control-line datepick', 'required', 'id' => 'data-inicio', 'readonly']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-12">Data de Fim</label>
                <div class="col-md-12">
                    {!! Form::text('data_fim', $dataFim, ['class' => 'form-control form-control-line datepick', 'required', 'id' => 'data-fim', 'readonly']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-2 col-md-offset-10" style="padding-top: 10px;">
            <button class="btn btn-primary" type="submit">Consultar</button>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="row">
        <h4>Total de {{ $reservas->count() }} reservas.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Numero de quarto</th>
                <th>Data de entrada</th>
                <th>Data de saida</th>
                <th>Valor total</th>
                <th>Quantia paga</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->getQuarto()->getNumero() }}</td>
                    <td>{{ $reserva->getDataEntrada() }}</td>
                    <td>{{ $reserva->getDataSaida() }}</td>
                    <td>R$ {{ $reserva->getValorTotal() }}</td>
                    <td>R$ {{ $reserva->getTotalPago() }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row text-right no-print">
        <button class="btn btn-primary" onclick="print()">
            <i class="fa fa-print"></i> Imprimir
        </button>
    </div>
    <div class="floating-menu no-print">
        <a href="{{ route('reservas.index') }}" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-arrow-circle-o-left"></i>
        </a>
    </div>
@stop
@section('js')
    <script src="{{ url('js/bootstrap-select.min.js') }}"></script>
    <script>
        $('.datepick').datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
            dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
            monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            nextText: 'Próximo',
            prevText: 'Anterior'
        });
    </script>
@stop
@section('css')
    <link rel="stylesheet" href="{{ url('css/datepicker.css') }}">
    <link rel="stylesheet" href="{{ url('css/bootstrap-select.min.css') }}">
@stop