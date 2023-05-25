@extends('template.layout')

@section('titulo', 'Disciplinas')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Gestão</li>
        <li class="breadcrumb-item">Curricular</li>
        <li class="breadcrumb-item active">Disciplinas</li>
    </ol>
@endsection

@section('main')
    <p><a class="btn btn-success" href="{{ route('disciplinas.create') }}"><i class="fas fa-plus"></i> &nbsp;Criar nova
            disciplina</a></p>
    <hr>
    <form method="GET" action="{{ route('disciplinas.index') }}">
        <div class="d-flex justify-content-between">
            <div class="flex-grow-1 pe-2">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1 mb-3 form-floating">
                        <select class="form-select" name="curso" id="inputCurso">
                            <option {{ old('curso', $filterByCurso) === '' ? 'selected' : '' }} value="">
                                Todos Cursos </option>
                            @foreach ($cursos as $curso)
                                <option {{ old('curso', $filterByCurso) == $curso->abreviatura ? 'selected' : '' }}
                                    value="{{ $curso->abreviatura }}">
                                    {{ $curso->tipo }} - {{ $curso->nome }}</option>
                            @endforeach
                        </select>
                        <label for="inputCurso" class="form-label">Curso</label>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="mb-3 me-2 flex-grow-1 form-floating">
                        <select class="form-select" name="ano" id="inputAno">
                            <option {{ old('ano', $filterByAno) === '' ? 'selected' : '' }} value="">Todos
                            </option>
                            @for ($i = 1; $i <= 3; $i++)
                                <option {{ old('ano', $filterByAno) == $i ? 'selected' : '' }} value="{{ $i }}">
                                    {{ $i }}</option>
                            @endfor
                        </select>
                        <label for="inputAno" class="form-label">Ano</label>
                    </div>
                    <div class="mb-3 flex-grow-1 form-floating">
                        <select class="form-select" name="semestre" id="inputSemestre">
                            <option {{ old('semestre', $filterBySemestre) === '' ? 'selected' : '' }} value="">
                                Todos
                            </option>
                            <option {{ old('semestre', $filterBySemestre) == 0 ? 'selected' : '' }} value="0">Anual
                            </option>
                            <option {{ old('semestre', $filterBySemestre) == 1 ? 'selected' : '' }} value="1">1º
                            </option>
                            <option {{ old('semestre', $filterBySemestre) == 2 ? 'selected' : '' }} value="2">2º
                            </option>
                        </select>
                        <label for="inputSemestre" class="form-label">Semestre</label>
                    </div>
                </div>
            </div>
            <div class="flex-shrink-1 d-flex flex-column justify-content-between">
                <button type="submit" class="btn btn-primary mb-3 px-4 flex-grow-1" name="filtrar">Filtrar</button>
                <a href="{{ route('disciplinas.index') }}"
                    class="btn btn-secondary mb-3 py-3 px-4 flex-shrink-1">Limpar</a>
            </div>
        </div>
    </form>
    @include('disciplinas.shared.table', [
        'disciplinas' => $disciplinas,
        'showCurso' => true,
        'showDetail' => true,
        'showEdit' => true,
        'showDelete' => true,
        'showAddCart' => true,
    ])
    <div>
        {{ $disciplinas->withQueryString()->links() }}
    </div>
@endsection
