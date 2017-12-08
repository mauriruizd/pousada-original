@extends('master')
@section('title', 'Realizar Checkin')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Início</a>
    > <a href="{{ route('estadas.index') }}">Estadas</a>
    > Checkin
@stop
@section('search-url', route('estadas.index'))
@section('content')
    <div class="loader"></div>
    {!! Form::open(['route' => ['estadas.checkin', $reserva->getId()], 'method' => 'POST', 'class' => 'form-horizontal form-material']) !!}
    <div class="form-group">
        <label class="col-md-12">Hospedes</label>
        @foreach($clientes as $id => $nome)
            <label class="col-md-12">
                {!! Form::checkbox('hospedes[]', $id, $reserva->getClienteReservante()->getId() === $id, $reserva->getClienteReservante()->getId() === $id ? ['onclick' => 'return false;', 'class' => 'hospede'] : ['onclick' => 'return checkMax();', 'class' => 'hospede']) !!} {{ $nome }}
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
        const max = "{{ $reserva->getQuarto()->getTipoQuarto()->getCapacidade() }}";
        function checkMax() {
            return $('.hospede:checked').length < max;
        }
    </script>
@stop