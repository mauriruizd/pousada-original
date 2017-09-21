@extends('layouts.app')

@section('content')
        <div class="row">
            <img src="{{ url('img/logo_pousada.png') }}" class="img-responsive logoimg"/>
        </div>
    <form class="login-form" method="post" action="{{ url('login') }}">
        {{ csrf_field() }}
        <input type="email" class="{{ $errors->has('email') ? 'has-error' : '' }}" placeholder="E-mail" name="email"/>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
        <input type="password" class="{{ $errors->has('password') ? 'has-error' : '' }}" placeholder="Senha" name="password"/>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
        <div>
            <label>
                <input type="checkbox" name="remember" style="width: auto;" {{ old('remember') ? 'checked' : ''}}>
                Lembrar-me
            </label>
        </div>
        <button type="submit">Entrar</button>
        <p class="message">Esqueceu sua senha? <a href="{{ url('/password/reset') }}">Lembrar senha</a></p>
    </form>
@endsection
