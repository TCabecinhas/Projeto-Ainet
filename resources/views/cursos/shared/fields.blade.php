@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp
<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('abreviatura') is-invalid @enderror" name="abreviatura" id="inputAbr"
        {{ $disabledStr }} value="{{ old('abreviatura', $curso->abreviatura) }}">
    <label for="inputAbr" class="form-label">Abreviatura</label>
    @error('abreviatura')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" id="inputNome"
        {{ $disabledStr }} value="{{ old('nome', $curso->nome) }}">
    <label for="inputNome" class="form-label">Nome</label>
    @error('nome')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3 form-floating">
    <select class="form-select @error('tipo') is-invalid @enderror" name="tipo" id="inputTipo" {{ $disabledStr }}>
        <option {{ $curso->tipo == 'Licenciatura' ? 'selected' : '' }}>Licenciatura</option>
        <option {{ $curso->tipo == 'Mestrado' ? 'selected' : '' }}>Mestrado</option>
        <option {{ $curso->tipo == 'Curso Técnico Superior Profissional' ? 'selected' : '' }}>Curso Técnico
            Superior Profissional</option>
    </select>
    <label for="inputTipo" class="form-label">Tipo de Curso</label>
    @error('tipo')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('semestres') is-invalid @enderror" name="semestres"
        id="inputSemestre" {{ $disabledStr }} value="{{ old('semestres', $curso->semestres) }}">
    <label for="inputSemestre" class="form-label">Semestres</label>
    @error('semestres')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('ECTS') is-invalid @enderror" name="ECTS" id="inputECTS"
        {{ $disabledStr }} value="{{ old('ECTS', $curso->ECTS) }}">
    <label for="inputECTS" class="form-label">ECTS</label>
    @error('ECTS')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('vagas') is-invalid @enderror" name="vagas" id="inputVagas"
        {{ $disabledStr }} value="{{ old('vagas', $curso->vagas) }}">
    <label for="inputVagas" class="form-label">Vagas</label>
    @error('vagas')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('contato') is-invalid @enderror" name="contato" id="inputContato"
        {{ $disabledStr }} value="{{ old('contato', $curso->contato) }}">
    <label for="inputContato" class="form-label">Contato</label>
    @error('contato')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3 form-floating">
    <textarea class="form-control height-lg @error('objetivos') is-invalid @enderror" name="objetivos" id="inputObjetivos"
        {{ $disabledStr }}>
        {{ old('objetivos', $curso->objetivos) }}
    </textarea>
    <label for="inputObjetivos" class="form-label">Objetivos</label>
    @error('objetivos')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
