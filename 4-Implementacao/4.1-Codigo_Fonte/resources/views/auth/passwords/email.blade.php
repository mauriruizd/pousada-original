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
    <h6>Recuperar Senha</h6>
    <form class="login-form" role="form" method="POST" action="{{ url('/password/email') }}">
        {{ csrf_field() }}
        <input type="email" class="" placeholder="E-mail" name="email" value="{{ old('email') }}" required/>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
        <button type="submit">Enviar email para redefinir senha</button>
    </form>
@endsection