{!! Form::hidden('estados-endpoint', url('fornecedores/select/estados'), ['id' => 'estados-endpoint']) !!}
{!! Form::hidden('cidades-endpoint', url('fornecedores/select/cidades'), ['id' => 'cidades-endpoint']) !!}

<div class="form-group">
    <label class="col-md-12">Nome</label>
    <div class="col-md-12">
        {!! Form::text('nome', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o nome do fornecedor', 'maxlength' => 254, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">CPNJ</label>
    <div class="col-md-12">
        {!! Form::number('cnpj', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o CNPJ do fornecedor', 'maxlength' => 14, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">CEP</label>
    <div class="col-md-12">
        {!! Form::text('cep', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o CEP do fornecedor', 'maxlength' => 254]) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Endereço</label>
    <div class="col-md-12">
        {!! Form::text('endereco', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o endereço do fornecedor', 'maxlength' => 254]) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Número</label>
    <div class="col-md-12">
        {!! Form::text('numero', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o número de casa do fornecedor', 'maxlength' => 254]) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Complemento</label>
    <div class="col-md-12">
        {!! Form::text('complemento', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o complemento do endereço', 'maxlength' => 254]) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">País</label>
    <div class="col-md-12">
        {!! $paises !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Estado</label>
    <div class="col-md-12">
        {!! $estados !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Cidade</label>
    <div class="col-md-12">
        {!! $cidades !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Fone</label>
    <div class="col-md-12">
        {!! Form::text('fone', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o número de telefone do fornecedor', 'maxlength' => 254]) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">E-mail</label>
    <div class="col-md-12">
        {!! Form::text('email', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o e-mail do fornecedor', 'maxlength' => 254]) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Site</label>
    <div class="col-md-12">
        {!! Form::text('site', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o endereço do website do fornecedor', 'maxlength' => 254]) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-12">Nome do Encarregado</label>
    <div class="col-md-12">
        {!! Form::text('nome_encarregado', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o nome do encarregado do fornecedor', 'maxlength' => 254]) !!}
    </div>
</div>