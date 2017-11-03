@extends('master')
@section('title', 'Listagem de Souvenirs Arquivados')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('souvenirs.index') }}">Souvenirs</a>
    > Arquivados
@stop
@section('search-url', route('souvenirs.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Souvenirs encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $souvenirs->count() }} souvenirs.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Recuperar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($souvenirs as $souvenir)
                <tr>
                    <td>{{ $souvenir->getNome() }}</td>
                    <td>
                        <a href="{{ route('souvenirs.recuperar', [$souvenir->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $souvenirs->render() !!}
    </div>
    <div class="floating-menu">
        <a href="{{ route('souvenirs.index') }}" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-arrow-circle-o-left"></i>
        </a>
    </div>
@stop