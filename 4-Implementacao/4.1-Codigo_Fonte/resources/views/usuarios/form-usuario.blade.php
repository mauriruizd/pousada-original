<div class="form-group">
    <label class="col-md-12">Nome</label>
    <div class="col-md-12">
        {!! Form::text('nome', isset($usuario) ? $usuario->getNome() : null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu nome', 'maxlength' => 254, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">E-mail</label>
    <div class="col-md-12">
        {!! Form::email('email', isset($usuario) ? $usuario->getEmail() : null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira seu e-mail', 'maxlength' => 254, 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Senha</label>
    <div class="col-md-12">
        {!! Form::password('password', ['class' => 'form-control form-control-line', 'placeholder' => 'Insira sua senha. Mínimo de 6 caracteres', 'maxlength' => 254, isset($usuario) ? '' : 'required']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-12">Confirmar Senha</label>
    <div class="col-md-12">
        {!! Form::password('password_confirmation', ['class' => 'form-control form-control-line', 'placeholder' => 'Insira sua senha. Mínimo de 6 caracteres', 'maxlength' => 254, isset($usuario) ? '' : 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Tipo de Usuário</label>
    <div class="col-md-12">
        {!! Form::select('tipo', $tipos, isset($usuario) ? $usuario->getTipo() : null, ['class' => 'form-control form-control-line']) !!}
    </div>
</div>
