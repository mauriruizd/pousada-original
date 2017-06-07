<div class="form-group">
    <label class="col-md-12">Nome</label>
    <div class="col-md-12">
        {!! Form::text('nome', isset($usuario) ? $usuario->getNome() : null, ['class' => 'form-control form-control-line', 'placeholder' => 'Vinícius Correia Silva']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">E-mail</label>
    <div class="col-md-12">
        {!! Form::text('email', isset($usuario) ? $usuario->getEmail() : null, ['class' => 'form-control form-control-line', 'placeholder' => 'viniciuscorreia@gmail.com']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Senha</label>
    <div class="col-md-12">
        {!! Form::text('password', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Mínimo de 6 caracteres']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Tipo de Usuário</label>
    <div class="col-md-12">
        {!! Form::select('tipo', $tipos, isset($usuario) ? $usuario->getTipo() : null, ['class' => 'form-control form-control-line']) !!}
    </div>
</div>
