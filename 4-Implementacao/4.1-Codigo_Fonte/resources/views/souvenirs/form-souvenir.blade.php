<div class="form-group">
    <label class="col-md-12">Nome</label>
    <div class="col-md-12">
        {!! Form::text('nome', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o nome do produto', 'maxlength' => 254, 'required', 'autofocus']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Preço</label>
    <div class="col-md-12">
        {!! Form::number('preco', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o preço do souvenir', 'step' => 0.50, 'min' => 0, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Foto</label>
    <div class="col-md-12">
        {!! Form::file('imagem_url', ['class' => 'form-control form-control-line', 'accept' => 'image/*']) !!}
    </div>
</div>