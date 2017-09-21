{!! Form::hidden('estados-endpoint', url('clientes/select/estados'), ['id' => 'estados-endpoint']) !!}
{!! Form::hidden('cidades-endpoint', url('clientes/select/cidades'), ['id' => 'cidades-endpoint']) !!}

<div class="form-group">
    <label class="col-md-12">Nome</label>
    <div class="col-md-12">
        {!! Form::text('nome', isset($cliente) ? $cliente->getNome() : null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu nome', 'maxlength' => 254, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">E-mail</label>
    <div class="col-md-12">
        {!! Form::email('email', isset($cliente) ? $cliente->getEmail() : null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu e-mail', 'maxlength' => 254, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Telefone</label>
    <div class="col-md-12">
        {!! Form::text('telefone', isset($cliente) ? $cliente->getTelefone() : null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu telefone', 'maxlength' => 254, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Celular</label>
    <div class="col-md-12">
        {!! Form::text('celular', isset($cliente) ? $cliente->getCelular() : null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu celular', 'maxlength' => 254, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Profissão</label>
    <div class="col-md-12">
        {!! Form::text('profissao', isset($cliente) ? $cliente->getProfissao() : null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira sua profissão', 'maxlength' => 254, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Nacionalidade</label>
    <div class="col-md-12">
        {!! $nacionalidade !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Data de Nascimento</label>
    <div class="col-md-12">
        {!! Form::text('dataNascimento', isset($cliente) ? $cliente->getDataNascimento()->format('d/m/Y') : null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira sua data de Nascimento', 'id' => 'data-nascimento', 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Documento de Identidade</label>
    <div class="col-md-12">
        {!! Form::text('dni', isset($cliente) ? $cliente->getDni() : null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu documento de identidade', 'maxlength' => 254, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">CPF</label>
    <div class="col-md-12">
        {!! Form::text('cpf', isset($cliente) ? $cliente->getCpf() : null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu CPF', 'maxlength' => 12, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Gênero</label>
    <div class="col-md-3">
        <label>
            {!! Form::radio('genero', \App\Entities\Enumeration\Genero::$MASCULINO, isset($cliente) ? $cliente->getGenero() === \App\Entities\Enumeration\Genero::$MASCULINO : true) !!} Masculino
        </label>
    </div>
    <div class="col-md-3">
        <label>
            {!! Form::radio('genero', \App\Entities\Enumeration\Genero::$FEMININO, isset($cliente) ? $cliente->getGenero() === \App\Entities\Enumeration\Genero::$FEMININO : null) !!} Feminino
        </label>
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Endereco</label>
    <div class="col-md-12">
        {!! Form::text('endereco', isset($cliente) ? $cliente->getEndereco() : null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu endereço', 'maxlength' => 254, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Pais de Residência</label>
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
    <label class="col-md-12">Observações</label>
    <div class="col-md-12">
        {!! Form::textarea('observacoes', isset($cliente) ? $cliente->getObservacoes() : null, ['class' => 'form-control', 'placeholder' => 'Insira suas observações']) !!}
    </div>
</div>