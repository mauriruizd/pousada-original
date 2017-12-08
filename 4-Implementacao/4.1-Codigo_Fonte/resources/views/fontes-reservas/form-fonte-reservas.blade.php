<div class="form-group">
    <label class="col-md-12">Nome</label>
    <div class="col-md-12">
        {!! Form::text('nome', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o nome da categoria de produtos', 'maxlength' => 254, 'required', 'autofocus']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-12">Metodos de pagamento disponíveis</label>
    <div class="col-md-12">
        <label>
            {!! Form::checkbox('pagamento_vista', 1, isset($fonte) ? $fonte->getPagamentoVista() === 1 : 0) !!} Pagamento à vista
        </label>
        <label>
            {!! Form::checkbox('pagamento_parcelado', 1, isset($fonte) ? $fonte->getPagamentoParcelado() === 1 : 0) !!} Pagamento parcelado
        </label>
    </div>
</div>

<div class="form-group">
    <label class="col-md-12">Percentagem de pagamento à vista</label>
    <div class="col-md-12">
        {!! Form::number('percentagem_vista', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira a percentagem do pagamento à vista', 'min' => 0, 'required', 'step' => 0.01]) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-12">Percentagem de pagamento parcelado</label>
    <div class="col-md-12">
        {!! Form::number('percentagem_parcelado', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira a percentagem do pagamento parcelado', 'min' => 0, 'required', 'step' => 0.01]) !!}
    </div>
</div>