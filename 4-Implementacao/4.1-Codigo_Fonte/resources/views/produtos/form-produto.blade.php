<div class="form-group">
    <label class="col-md-12">Nome</label>
    <div class="col-md-12">
        {!! Form::text('nome', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o nome do produto', 'maxlength' => 254, 'required', 'autofocus']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Categoria</label>
    <div class="col-md-12">
        {!! Form::select('id_categoria', $categorias, null, ['class' => 'form-control form-control-line', 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Fornecedor</label>
    <div class="col-md-12">
        {!! Form::select('id_fornecedor', $fornecedores, null, ['class' => 'form-control form-control-line', 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Estoque Mínimo</label>
    <div class="col-md-12">
        {!! Form::number('estoque_minimo', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o estoque mínimo do produto', 'maxlength' => 254, 'required', 'min' => 0, 'max' => 4294967295]) !!}
    </div>
</div>
@if(!isset($produto))
<div class="form-group">
    <label class="col-md-12">Estoque Inicial</label>
    <div class="col-md-12">
        {!! Form::number('estoque_inicial', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o estoque inicial do produto', 'maxlength' => 254, 'required', 'min' => 0, 'max' => 4294967295]) !!}
    </div>
</div>
@else
<div class="row">
    <label class="col-md-12">Estoque</label>
    <div class="col-md-12">
        {{ $produto->getEstoque() }}
    </div>
</div>
@endif
<div class="form-group">
    <label class="col-md-12">Preço de venda</label>
    <div class="col-md-12">
        {!! Form::number('preco', isset($produto) ? $produto->getPrecos()->sortByDesc('datahora_cadastro')->first()->preco : null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o preço do produto', 'step' => 0.50, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Foto</label>
    <div class="col-md-12">
        {!! Form::file('imagen_url', ['class' => 'form-control form-control-line', 'accept' => 'image/*']) !!}
    </div>
</div>