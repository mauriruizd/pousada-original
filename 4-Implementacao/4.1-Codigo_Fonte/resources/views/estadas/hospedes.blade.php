@extends('master')
@section('title', 'Realizar Checkin')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('estadas.index') }}">Estadas</a>
    > <a href="{{ route('estadas.show', [$estada->getId()]) }}">{{ $estada->getQuarto()->getNumero() }}</a>
    > Editar Lista de Hospedes
@stop
@section('search-url', route('estadas.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => ['estadas.update-hospedes', $estada->getId()], 'method' => 'PUT', 'class' => 'form-horizontal form-material']) !!}
    <div class="form-group">
        <label class="col-md-12">Hospedes</label>
        @foreach($clientes as $id => $nome)
            <label class="col-md-12">
                {!! Form::checkbox('hospedes[]', $id, $hospedes->filter(function ($h) use ($id) { return $h == $id; })->count() > 0, $estada->getReserva()->getClienteReservante()->getId() === $id ? ['onclick' => 'return false;', 'class' => 'hospede'] : ['onclick' => 'return checkMax;', 'class' => 'hospede']) !!} {{ $nome }}
            </label>
        @endforeach
    </div>
    <div class="floating-menu">
        <button type="submit" class="btn btn-primary btn-rounded btn-lg menu-main">
            <i class="fa fa-check"></i>
        </button>
    </div>
    {!! Form::close() !!}
@stop
@section('js')
    <script>
        const max = "{{ $estada->getQuarto()->getTipoQuarto()->getCapacidade() }}";
        function checkMax() {
            return $('.hospede:checked').length < max;
        }
    </script>
@stop