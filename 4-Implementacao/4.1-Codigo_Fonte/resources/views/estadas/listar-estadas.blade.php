@extends('master')
@section('title', 'Listagem de Estadas')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > Estadas
@stop
@section('search-url', route('estadas.index'))
@section('content')
    <div class="row">
        @if(!is_null($search))
            <h4>Estadas abertas encontrados para "{{ $search }}".</h4>
        @endif
        <h4>Total de {{ $estadas->count() }} estadas.</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Quarto</th>
                <th>Realizar Checkout</th>
                <th>Editar Lista de Hospedes</th>
                <th>Alterar Quarto</th>
                <th>Registrar Consumo do Frigobar</th>
                <th>Registrar Dano do Quarto</th>
                <th>Consultar Estado da Conta</th>
                <th>Extender Estada</th>
            </tr>
            </thead>
            <tbody>
            @foreach($estadas as $estada)
                <tr>
                    <td>{{ $estada->getQuarto()->getNumero() }}</td>
                    <td>
                        @if($estada->getSaldo() == 0)
                            {!! Form::open(['route' => ['estadas.checkout', $estada->getId()], 'method' => 'POST']) !!}
                                <button type="submit" class="btn btn-primary">Realizar checkout</button>
                            {!! Form::close() !!}
                        @else
                            <i class="text-danger">Pagamento pendente</i>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('estadas.edit-hospedes', [$estada->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-group"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('estadas.edit-quarto', [$estada->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-bed"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('estadas.create-frigobar', [$estada->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-cutlery"></i>
                        </a>
                    </td>

                    <td>
                        <a href="{{ route('estadas.create-dano', [$estada->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-gavel"></i>
                        </a>
                    </td>

                    <td>
                        <a href="{{ route('estadas.estado-conta', [$estada->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-credit-card"></i>
                        </a>
                    </td>

                    <td>
                        <a href="{{ route('estadas.create-extender', [$estada->getId()]) }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $estadas->render() !!}
    </div>
    {{--<div class="floating-menu">--}}
        {{--<div class="submenu">--}}
            {{--<a href="{{ route('estadas.checkin-form') }}" class="btn btn-primary btn-rounded" title="Realizar checkin">--}}
                {{--<i class="fa fa-plus"></i>--}}
            {{--</a>--}}
        {{--</div>--}}
        {{--<button class="btn btn-primary btn-rounded btn-lg menu-main">--}}
            {{--<i class="fa fa-bars"></i>--}}
        {{--</button>--}}
    {{--</div>--}}
@stop