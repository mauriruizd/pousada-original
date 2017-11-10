<div class="form-group">
    <label class="col-md-12">Nome</label>
    <div class="col-md-12">
        {!! Form::text('nome', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o nome do comissionista', 'maxlength' => 254, 'required', 'autofocus']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Telefone</label>
    <div class="col-md-12">
        {!! Form::text('telefone', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insita o telefone do comissionista', 'maxlength' => 254]) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Categoria</label>
    <div class="col-md-12">
        {!! Form::select('id_categoria', $categorias, null, ['class' => 'form-control form-control-line', 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Percentagem</label>
    <div class="col-md-12">
        {!! Form::number('percentagem', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira a percentagem', 'required', 'min' => 0, 'step' => 0.5, 'max' => 4294967295]) !!}
    </div>
</div>