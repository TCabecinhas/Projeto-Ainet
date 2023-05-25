@extends('template.layout')

@section('titulo', 'Candidaturas')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Candidaturas</li>
        <li class="breadcrumb-item active">Candidaturas</li>
    </ol>
@endsection

@section('main')
    <form method="GET" action="{{ route('candidaturas.index') }}">
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
            </div>
            <div class="flex-shrink-1 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary mb-3 me-2 px-4 flex-grow-1" name="filtrar">Filtrar</button>
                <a href="{{ route('candidaturas.index') }}"
                    class="btn btn-secondary mb-3 py-3 px-4 flex-shrink-1">Limpar</a>
            </div>
        </div>
    </form>
    @include('candidaturas.shared.table', [
        'candidaturas' => $candidaturas,
        'showDetail' => true,
    ])
    <div>
        {{ $candidaturas->withQueryString()->links() }}
    </div>
@endsection
