@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp
<div class="mb-3 form-floating">
    <select class="form-select @error('curso') is-invalid @enderror" name="curso" id="inputCurso" {{ $disabledStr }}>
        @foreach ($cursos as $curso)
            <option {{ $curso->abreviatura == old('curso', $candidatura->curso) ? 'selected' : '' }}
                value="{{ $curso->abreviatura }}">
                {{ $curso->tipo }} - {{ $curso->nome }}</option>
        @endforeach
    </select>
    <label for="inputCurso" class="form-label">Curso</label>
    @error('curso')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" id="inputNome"
        {{ $disabledStr }} value="{{ old('nome', $candidatura->nome) }}">
    <label for="inputNome" class="form-label">Nome</label>
    @error('nome')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="inputEmail"
        {{ $disabledStr }} value="{{ old('email', $candidatura->email) }}">
    <label for="inputEmail" class="form-label">E-mail</label>
    @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>


<div class="d-flex justify-content-between">
    <div class="mb-3 form-floating flex-grow-1">
        <select class="form-select @error('genero') is-invalid @enderror" name="genero" id="inputGenero"
            {{ $disabledStr }}>
            <option {{ old('genero', $candidatura->genero) == 'M' ? 'selected' : '' }} value="M">Masculino
            </option>
            <option {{ old('genero', $candidatura->genero) == 'F' ? 'selected' : '' }} value="F">Feminino
            </option>
        </select>
        <label for="inputGenero" class="form-label">Gênero</label>
        @error('genero')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="d-flex justify-content-between">
        <div class="mb-3 ms-3 form-floating flex-grow-1">
            <input type="text" class="form-control @error('telefone1') is-invalid @enderror" name="telefone1"
                id="inputTelefone1" {{ $disabledStr }} value="{{ old('telefone1', $candidatura->telefone1) }}">
            <label for="inputTelefone1" class="form-label">1º Telefone</label>
            @error('telefone1')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3 ms-3 form-floating flex-grow-1">
            <input type="text" class="form-control @error('telefone2') is-invalid @enderror" name="telefone2"
                id="inputTelefone2" {{ $disabledStr }} value="{{ old('telefone2', $candidatura->telefone2) }}">
            <label for="inputTelefone2" class="form-label">2º Telefone</label>
            @error('telefone2')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>

<div class="d-flex justify-content-between">
    <div class="mb-3 form-floating flex-grow-1">
        <input type="text" class="form-control @error('media') is-invalid @enderror" name="media" id="inputMedia"
            {{ $disabledStr }} value="{{ old('media', $candidatura->media) }}">
        <label for="inputMedia" class="form-label">Média</label>
        @error('media')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3 ms-4 me-2 d-flex align-items-center">
        <div class="form-check form-switch" {{ $disabledStr }}>
            <input type="hidden" name="m23" value="0">
            <input type="checkbox" class="form-check-input @error('m23') is-invalid @enderror" name="m23"
                id="inputM23" {{ $disabledStr }} {{ old('m23', $candidatura->m23) ? 'checked' : '' }}
                value="1">
            <label for="inputM23" class="form-check-label">Maior de 23</label>
            @error('m23')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>
<div class="d-flex justify-content-between">
    <div class="mb-3 form-floating  flex-grow-1">
        <div class="form-control @error('origem') is-invalid @enderror d-flex flex-column justify-content-between"
            style="height: 160px;" id="inputOrigem">
            <div class="form-check mt-3" {{ $disabledStr }}>
                <input class="form-check-input" type="radio" name="origem" id="inputOrigemPT" value="P"
                    {{ old('origem', $candidatura->origem) == 'P' ? 'checked' : '' }} {{ $disabledStr }}>
                <label class="form-check-label" for="inputOrigemPT">
                    Portugal
                </label>
            </div>
            <div class="form-check" {{ $disabledStr }}>
                <input class="form-check-input" type="radio" name="origem" id="inputOrigemUE" value="UE"
                    {{ old('origem', $candidatura->origem) == 'UE' ? 'checked' : '' }} {{ $disabledStr }}>
                <label class="form-check-label" for="inputOrigemUE">
                    União Europeia
                </label>
            </div>
            <div class="form-check" {{ $disabledStr }}>
                <input class="form-check-input" type="radio" name="origem" id="inputOrigemO" value="O"
                    {{ old('origem', $candidatura->origem) == 'O' ? 'checked' : '' }} {{ $disabledStr }}>
                <label class="form-check-label" for="inputOrigemO">
                    Outros
                </label>
            </div>
        </div>
        <label for="inputOrigem" class="form-label">Origem</label>
        @error('origem')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3 form-floating ms-3 flex-grow-1">
        <div class="form-control @error('estatutos') is-invalid @enderror d-flex flex-column justify-content-between"
            style="height: 160px;" id="inputEstatutos">

            <div class="form-check mt-3" {{ $disabledStr }}>
                <input type="hidden" name="estatutos[TE]" value="0">
                <input class="form-check-input" type="checkbox" name="estatutos[TE]" id="inputEstatutosTE"
                    {{ old('estatutos', $candidatura->estatutosArray)['TE'] ?? 0 ? 'checked' : '' }} value="1"
                    {{ $disabledStr }}>
                <label class="form-check-label" for="inputEstatutosTE">
                    Trabalhador Estudante
                </label>
            </div>
            <div class="form-check" {{ $disabledStr }}>
                <input type="hidden" name="estatutos[NE]" value="0">
                <input class="form-check-input" type="checkbox" name="estatutos[NE]" id="inputEstatutosNE"
                    {{ old('estatutos', $candidatura->estatutosArray)['NE'] ?? 0 ? 'checked' : '' }} value="1"
                    {{ $disabledStr }}>
                <label class="form-check-label" for="inputEstatutosNE">
                    Necessidades Especiais
                </label>
            </div>
            <div class="form-check" {{ $disabledStr }}>
                <input type="hidden" name="estatutos[E]" value="0">
                <input class="form-check-input" type="checkbox" name="estatutos[E]" id="inputEstatutosE"
                    {{ old('estatutos', $candidatura->estatutosArray)['E'] ?? 0 ? 'checked' : '' }} value="1"
                    {{ $disabledStr }}>
                <label class="form-check-label" for="inputEstatutosE">
                    Erasmus
                </label>
            </div>
        </div>
        <label for="inputEstatutos" class="form-label">Estatutos Pretendidos</label>
        @error('estatutos')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="mb-3 form-floating">
    <textarea class="form-control height-lg @error('obs') is-invalid @enderror" name="obs" id="inputObs"
        {{ $disabledStr }}>
        {{ old('obs', $curso->obs) }}
    </textarea>
    <label for="inputObs" class="form-label">Observações</label>
    @error('obs')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
