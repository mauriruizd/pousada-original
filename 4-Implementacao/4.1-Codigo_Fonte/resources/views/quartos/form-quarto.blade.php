<div class="form-group">
    <label class="col-md-12">Número de Quarto</label>
    <div class="col-md-12">
        @if(isset($quarto))
            <p>{{ $quarto->getNumero() }}</p>
        @else
            {!! Form::text('numero', isset($quarto) ? $quarto->getNumero() : null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o número de quarto']) !!}
        @endif
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Andar</label>
    <div class="col-md-12">
        {!! Form::number('andar', null, ['class' => 'form-control form-control-line', 'placeholder' => 'Insira o andar do quarto', 'min' => 1, 'max' => 3]) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Tipo de Quarto</label>
    <div class="col-md-12">
        {!! $tiposQuartos !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-12">Fotos</label>
    <div class="col-md-12">
        <input type="file" multiple name="fotos[]">
    </div>
</div>
@if(isset($quarto))
    <div class="row">
    @foreach($quarto->getFotos() as $foto)
        <div class="col-md-3">
            <label>
                <input type="checkbox" name="img[]" value="{{ $foto->getId() }}" checked>
                <img src="{{ $foto->getUrl() }}" class="img-responsive">
            </label>
        </div>
    @endforeach
    </div>
    <div class="row">
        <p class="help-block">Selecione as fotos que deseje manter</p>
    </div>
@endif
