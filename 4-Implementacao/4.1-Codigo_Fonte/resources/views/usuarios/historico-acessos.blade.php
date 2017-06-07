@extends('master')
@section('title', 'Histórico de Acessos')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('usuarios.index') }}">Usuários</a>
    > <a href="{{ route('usuarios.show', [$usuario->getId()]) }}">{{ $usuario->getNome() }}</a>
    > Histórico de Acessos
@stop
@section('search-url', route('usuarios.index'))
@section('content')
    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th>Data e Hora</th>
                <th>Endereço IP</th>
            </tr>
            </thead>
            <tbody>
            @foreach($usuario->getAcessos() as $acesso)
                <tr>
                    <td>{{ $acesso->getTimestamp()->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $acesso->getIp() }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop