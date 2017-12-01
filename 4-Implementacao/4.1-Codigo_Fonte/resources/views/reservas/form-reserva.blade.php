{!! Form::hidden('consulta-endpoint', route('reservas.consultar-disponibilidade'), ['id' => 'consulta-endpoint']) !!}
<div class="row" style="padding-bottom: 10px;">
    <div class="col-md-12">
        {!! Form::label('id_cliente_reservante', 'Cliente reservante') !!}
    </div>
    {!! Form::select('id_cliente_reservante', $clientes, $idCliente, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) !!}
    <div class="col-md-2 col-md-offset-10">
        <a href="{{ route('clientes.create', ['fromReserva' => 'true']) }}" class="btn btn-primary">Novo Cliente</a>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-md-12">Data de Entrada</label>
            <div class="col-md-12">
                {!! Form::text('data_entrada', isset($reserva) ? null : (new \Carbon\Carbon())->format('d/m/Y'), ['class' => 'form-control form-control-line datepick', 'required', 'id' => 'data-entrada', 'readonly']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-md-12">Data de Saída</label>
            <div class="col-md-12">
                {!! Form::text('data_saida', isset($reserva) ? null : (new \Carbon\Carbon())->addDay(1)->format('d/m/Y'), ['class' => 'form-control form-control-line datepick', 'required', 'id' => 'data-saida', 'readonly']) !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
<div class="col-md-12" id="quartos-select-container"></div>
</div>
{{--<div class="form-group">--}}
    {{--<label class="col-md-12">Quarto</label>--}}
    {{--<div class="col-md-12" id="quartos-select-container">--}}
        {{--{!! Form::select('id_quarto', [], null, ['class' => 'form-control form-control-line', 'placeholder' => 'Selecione um quarto', 'required']) !!}--}}
    {{--</div>--}}
{{--</div>--}}
@if(!isset($reserva))
    <div class="form-group">
        <label class="col-md-12">Fonte da Reserva</label>
        <div class="col-md-12">
            {!! Form::select('id_fonte', $fontes, null, ['class' => 'form-control form-control-line', 'required']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12">Comissionista</label>
        <div class="col-md-12">
            {!! Form::select('id_comissionista', $comissionistas, null, ['class' => 'form-control form-control-line', 'placeholder' => 'Selecione um comissionista (opcional)']) !!}
        </div>
    </div>
@endif