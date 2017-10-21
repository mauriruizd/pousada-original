<div class="form-group">
    <label class="col-md-12">Nome</label>
    <div class="col-md-12">
        @if(!isset($tipoQuarto))
            {!! Form::text('nome', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu nome', 'maxlength' => 254, 'required']) !!}
        @else
            {{ $tipoQuarto->getNome() }}
        @endif
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Capacidade</label>
    <div class="col-md-12">
        {!! Form::number('capacidade', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira a capacidade do tipo de quarto', 'maxlength' => 20, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Preço</label>
    <div class="col-md-12">
        {!! Form::number('preco', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o preço do tipo de quarto', 'required', 'step' => 0.1]) !!}
    </div>
</div>