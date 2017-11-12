@extends('master')
@section('title', 'Listagem de Fontes Arquivados')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('fontes-reservas.index') }}">Fontes</a>
    > Arquivadas
@stop
@section('search-url', route('fontes-reservas.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Fontes encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $fontes->count() }} fontes.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Recuperar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($fontes as $fonte)
                <tr>
                    <td>{{ $fonte->getNome() }}</td>
                    <td>
                        <a href="{{ route('fontes-reservas.recuperar', [$fonte->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $fontes->render() !!}
    </div>
    <div class="floating-menu">
        <a href="{{ route('fontes-reservas.index') }}" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-arrow-circle-o-left"></i>
        </a>
    </div>
@stop