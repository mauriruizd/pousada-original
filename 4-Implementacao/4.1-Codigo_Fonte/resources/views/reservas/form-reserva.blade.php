{!! Form::hidden('consulta-endpoint', route('reservas.consultar-disponibilidade'), ['id' => 'consulta-endpoint']) !!}
<div class="form-group">
    <label class="col-md-12">Clientes</label>
    <div class="col-md-12">
        @foreach($clientes as $id => $nome)
            {!! Form::checkbox('clientes[]', $id, isset($reserva) ? $reserva->getClientes()->contains('id', $cliente->id) : false, ['id' => "cliente_$id"]) !!}
            {!! Form::label("cliente_$id", $nome) !!}
        @endforeach
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Data de Entrada</label>
    <div class="col-md-12">
        {!! Form::text('data_entrada', null, ['class' => 'form-control form-control-line datepick', 'required', 'id' => 'data-entrada']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Data de Saída</label>
    <div class="col-md-12">
        {!! Form::text('data_saida', null, ['class' => 'form-control form-control-line datepick', 'required', 'id' => 'data-saida']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Quarto</label>
    <div class="col-md-12" id="quartos-select-container">
        {!! Form::select('id_quarto', [], null, ['class' => 'form-control form-control-line', 'placeholder' => 'Selecione um quarto', 'required']) !!}
    </div>
</div>
@if(!isset($reserva))
    <div class="form-group">
        <label class="col-md-12">Fonte da Reserva</label>
        <div class="col-md-12">
            {!! Form::select('id_fonte', $fontes, null, ['class' => 'form-control form-control-line', 'placeholder' => 'Selecione a fonte da reserva', 'required']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12">Comissionista</label>
        <div class="col-md-12">
            {!! Form::select('id_comissionista', $comissionistas, null, ['class' => 'form-control form-control-line', 'placeholder' => 'Selecione um comissionista (opcional)']) !!}
        </div>
    </div>
@endif