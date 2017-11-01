@extends('master')
@section('title', 'Listado de Fornecedores Arquivados')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Fornecedores
@stop
@section('search-url', route('fornecedores.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Fornecedores encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $fornecedores->count() }} fornecedores.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Recuperar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($fornecedores as $fornecedor)
                <tr>
                    <td>{{ $fornecedor->getNome() }}</td>
                    <td>
                        <a href="{{ route('fornecedores.recuperar', [$fornecedor->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $fornecedores->render() !!}
    </div>
    <div class="floating-menu">
        <a href="{{ route('fornecedores.index') }}" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-arrow-circle-o-left"></i>
        </a>
    </div>
@stop