<div class="form-group">
    <label class="col-md-12">Preço promocional</label>
    <div class="col-md-12">
        {!! Form::text('preco', $tipoQuarto->getPrecoPromocional() === null ? null : $tipoQuarto->getPrecoPromocional(), ['class' => 'form-control form-control-line', 'placeholder' => 'Insira preço promocional']) !!}
    </div>
</div>