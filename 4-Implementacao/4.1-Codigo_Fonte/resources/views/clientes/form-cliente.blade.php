{!! Form::hidden('estados-endpoint', url('clientes/select/estados'), ['id' => 'estados-endpoint']) !!}
{!! Form::hidden('cidades-endpoint', url('clientes/select/cidades'), ['id' => 'cidades-endpoint']) !!}
@if($fromReserva)
    {!! Form::hidden('from-reserva', true) !!}
@endif
<div class="form-group">
    <label class="col-md-12">Nome</label>
    <div class="col-md-12">
        {!! Form::text('nome', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu nome', 'maxlength' => 254, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">E-mail</label>
    <div class="col-md-12">
        {!! Form::email('email', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu e-mail', 'maxlength' => 254, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Telefone</label>
    <div class="col-md-12">
        {!! Form::text('telefone', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu telefone', 'maxlength' => 254, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Celular</label>
    <div class="col-md-12">
        {!! Form::text('celular', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu celular', 'maxlength' => 254, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Profissão</label>
    <div class="col-md-12">
        {!! Form::text('profissao', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira sua profissão', 'maxlength' => 254, 'required']) !!}
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
        {!! Form::text('data_nascimento', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira sua data de Nascimento', 'id' => 'data-nascimento', 'required', 'readonly']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">RG</label>
    <div class="col-md-12">
        {!! Form::text('rg', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu RG', 'maxlength' => 254, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">CPF</label>
    <div class="col-md-12">
        {!! Form::text('cpf', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu CPF', 'maxlength' => 12, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Sexo</label>
    <div class="col-md-3">
        <label>
            {!! Form::radio('sexo', \App\Entities\Enumeration\Sexo::$MASCULINO, isset($cliente) ? $cliente->sexo === \App\Entities\Enumeration\Sexo::$MASCULINO : true) !!} Masculino
        </label>
    </div>
    <div class="col-md-3">
        <label>
            {!! Form::radio('sexo', \App\Entities\Enumeration\Sexo::$FEMININO, isset($cliente) ? $cliente->sexo === \App\Entities\Enumeration\Sexo::$FEMININO : null) !!} Feminino
        </label>
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Endereco</label>
    <div class="col-md-12">
        {!! Form::text('endereco', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu endereço', 'maxlength' => 254, 'required']) !!}
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
        {!! Form::textarea('observacoes', null, ['class' => 'form-control', 'placeholder' => 'Insira suas observações']) !!}
    </div>
</div>