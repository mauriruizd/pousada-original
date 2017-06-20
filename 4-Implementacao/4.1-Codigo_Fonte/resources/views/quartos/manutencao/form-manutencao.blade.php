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
    <label class="col-md-12">Motivo</label>
    <div class="col-md-12">
        {!! Form::textarea('motivo', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o motivo da manutenção']) !!}
    </div>
</div>