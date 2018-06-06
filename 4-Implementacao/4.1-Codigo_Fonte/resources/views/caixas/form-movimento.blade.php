@if(isset($max) && $max == 0)
    <div class="row">
        <div class="col-md-12">
            <i>Valor no caixa insuficiente para continuar com a transação</i>
        </div>
    </div>
@else
    <div class="form-group">
        <label class="col-md-12">Valor</label>
        <div class="col-md-12">
            {!! Form::number('valor', null, array_merge(['class' => 'form-control form-control-line', 'placeholder' => 'Insira o valor', 'min' => 1, 'required'], isset($max) ? ['max' => $max] : [])) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12">Motivo</label>
        <div class="col-md-12">
            {!! Form::textarea('motivo', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o motivo', 'required']) !!}
        </div>
    </div>
@endif