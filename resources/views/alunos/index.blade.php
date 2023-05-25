@extends('template.layout')

@section('titulo', 'Alunos')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Alunos</li>
    </ol>
@endsection

@section('main')
    <p><a class="btn btn-success" href="{{ route('alunos.create') }}"><i class="fas fa-plus"></i> &nbsp;Criar novo
            aluno</a></p>
    <hr>
    <form method="GET" action="{{ route('alunos.index') }}">
        <div class="d-flex justify-content-between">
            <div class="flex-grow-1 pe-2">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1 mb-3 form-floating">
                        <select class="form-select" name="curso" id="inputCurso">
                            <option {{ old('curso', $filterByCurso) === '' ? 'selected' : '' }} value="">Todos
                                Cursos </option>
                            @foreach ($cursos as $curso)
                                <option {{ old('curso', $filterByCurso) == $curso->abreviatura ? 'selected' : '' }}
                                    value="{{ $curso->abreviatura }}">{{ $curso->nome }}</option>
                            @endforeach
                        </select>
                        <label for="inputCurso" class="form-label">Curso</label>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="mb-3 me-2 flex-grow-1 form-floating">
                        <input type="text" class="form-control" name="nome" id="inputNome"
                            value="{{ old('nome', $filterByNome) }}">
                        <label for="inputNome" class="form-label">Nome</label>
                    </div>
                </div>
            </div>
            <div class="flex-shrink-1 d-flex flex-column justify-content-between">
                <button type="submit" class="btn btn-primary mb-3 px-4 flex-grow-1" name="filtrar">Filtrar</button>
                <a href="{{ route('alunos.index') }}" class="btn btn-secondary mb-3 py-3 px-4 flex-shrink-1">Limpar</a>
            </div>
        </div>
    </form>
    @include('alunos.shared.table', [
        'alunos' => $alunos,
        'showFoto' => true,
        'showDetail' => true,
        'showEdit' => true,
        'showDelete' => true,
    ])
    <div>
        {{ $alunos->withQueryString()->links() }}
    </div>
@endsection
