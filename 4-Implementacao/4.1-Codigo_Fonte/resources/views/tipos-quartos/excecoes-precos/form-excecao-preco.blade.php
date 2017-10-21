<div class="form-group">
    <label class="col-md-12">Preço</label>
    <div class="col-md-12">
        {!! Form::number('preco', isset($excecao) ? null : $tipoQuarto->getPreco(), ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o preço da exceção', 'required', 'step' => 0.1, 'max' => $tipoQuarto->getPreco()]) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Data de Início</label>
    <div class="col-md-12">
        {!! Form::text('data_inicio', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira a data de início', 'required', 'id' => 'data_inicio']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Data de Finalização</label>
    <div class="col-md-12">
        {!! Form::text('data_fim', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira a data de finalização', 'required', 'id' => 'data_fim']) !!}
    </div>
</div>