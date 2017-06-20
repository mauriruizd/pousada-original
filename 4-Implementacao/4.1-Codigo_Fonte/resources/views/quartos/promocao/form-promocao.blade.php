<div class="form-group">
    <label class="col-md-12">Número de Quarto</label>
    <div class="col-md-12">
        @if(isset($quarto))
            <p>{{ $quarto->getNumero() }}</p>
        @else
            {!! Form::text('numero', isset($quarto) ? $quarto->getNumero() : null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o número de quarto']) !!}
        @endif
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Preço</label>
    <div class="col-md-12">
        {!! Form::text('preco', isset($promocao) ? $promocao->getPreco() : null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o preço']) !!}
    </div>
</div>