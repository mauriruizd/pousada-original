@extends('master')
@section('title', 'Listado de Usuarios Arquivados')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Usuarios
@stop
@section('search-url', route('usuarios.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Usuarios encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $usuarios->count() }} usuarios.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Recuperar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->getNome() }}</td>
                    <td>
                        <a href="{{ route('usuarios.recuperar', [$usuario->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $usuarios->render() !!}
    </div>
    <div class="floating-menu">
        <a href="{{ route('usuarios.index') }}" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-arrow-circle-o-left"></i>
        </a>
    </div>
@stop