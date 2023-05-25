@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp
<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('abreviatura') is-invalid @enderror" name="abreviatura" id="inputAbr"
        {{ $disabledStr }} value="{{ old('abreviatura', $departamento->abreviatura) }}">
    <label for="inputAbr" class="form-label">Abreviatura</label>
    @error('abreviatura')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" id="inputNome"
        {{ $disabledStr }} value="{{ old('nome', $departamento->nome) }}">
    <label for="inputNome" class="form-label">Nome</label>
    @error('nome')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
