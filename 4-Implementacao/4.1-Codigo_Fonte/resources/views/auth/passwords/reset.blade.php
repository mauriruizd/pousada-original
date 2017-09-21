@extends('layouts.app')

@section('content')
    <div class="row">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <img src="{{ url('img/logo_pousada.png') }}" class="img-responsive logoimg"/>
    </div>
    <h6>Restaurar Senha</h6>
    <form class="login-form" role="form" method="POST" action="{{ url('/password/reset') }}">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="email" class="" placeholder="E-mail" name="email" value="{{ $email or old('email') }}" required autofocus/>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
        <input type="password" class="" placeholder="Senha" name="password" required/>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
        <input type="password" class="" placeholder="Repita a senha" name="password_confirmation" required/>
        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif

        <button type="submit">Alterar Senha</button>
    </form>
@endsection