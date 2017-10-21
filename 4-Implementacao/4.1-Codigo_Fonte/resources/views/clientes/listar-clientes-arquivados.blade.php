@extends('master')
@section('title', 'Listado de Clientes Arquivados')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Clientes
@stop
@section('search-url', route('clientes.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Clientes encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $clientes->count() }} clientes.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Documento de identidade</th>
                <th>Recuperar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->getNome() }}</td>
                    <td>{{ $cliente->getRg() }}</td>
                    <td>
                        <a href="{{ route('clientes.recuperar', [$cliente->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $clientes->render() !!}
    </div>
    <div class="floating-menu">
        <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-arrow-circle-o-left"></i>
        </a>
    </div>
@stop