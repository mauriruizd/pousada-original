@extends('master')
@section('title', 'Listagem de Comissionistas Arquivados')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('comissionistas.index') }}">Comissionistas</a>
    > Arquivados
@stop
@section('search-url', route('comissionistas.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Comissionistas encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $comissionistas->count() }} comissionistas.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Recuperar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($comissionistas as $comissionista)
                <tr>
                    <td>{{ $comissionista->getNome() }}</td>
                    <td>
                        <a href="{{ route('comissionistas.recuperar', [$comissionista->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $comissionistas->render() !!}
    </div>
    <div class="floating-menu">
        <a href="{{ route('comissionistas.index') }}" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-arrow-circle-o-left"></i>
        </a>
    </div>
@stop