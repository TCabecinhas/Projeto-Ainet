@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

<div class="d-flex justify-content-between">
    <div class="mb-3 form-floating flex-grow-1">
        <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" id="inputNumero"
            {{ $disabledStr }} value="{{ old('numero', $aluno->numero) }}">
        <label for="inputNumero" class="form-label">Nº Aluno</label>
        @error('numero')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="mb-3 form-floating">
    <select class="form-select @error('curso') is-invalid @enderror" name="curso" id="inputCurso" {{ $disabledStr }}>
        @foreach ($cursos as $curso)
            <option {{ $curso->abreviatura == old('curso', $aluno->curso) ? 'selected' : '' }}
                value="{{ $curso->abreviatura }}">
                {{ $curso->nome }}</option>
        @endforeach
    </select>
    <label for="inputCurso" class="form-label">Curso</label>
    @error('curso')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
