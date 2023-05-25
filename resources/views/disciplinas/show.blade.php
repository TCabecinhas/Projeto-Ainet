@extends('template.layout')

@section('titulo', 'Disciplina')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Gestão</li>
        <li class="breadcrumb-item">Curricular</li>
        <li class="breadcrumb-item"><a href="{{ route('disciplinas.index') }}">Disciplinas</a></li>
        <li class="breadcrumb-item"><strong>{{ $disciplina->nome }}</strong></li>
        <li class="breadcrumb-item active">Consultar</li>
    </ol>
@endsection

@section('main')
    <div>
        @include('disciplinas.shared.fields', ['readonlyData' => true])
    </div>
    <div class="my-4 d-flex justify-content-end">
        <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal"
            data-bs-target="#confirmationModal"
            data-msgLine1="Quer realmente apagar a disciplina <strong>&quot;{{ $disciplina->nome }}&quot;</strong>?"
            data-action="{{ route('disciplinas.destroy', ['disciplina' => $disciplina]) }}">
            Apagar Disciplina
        </button>
        <a href="{{ route('disciplinas.edit', ['disciplina' => $disciplina]) }}" class="btn btn-secondary ms-3">
            Alterar Disciplina
        </a>
    </div>
    <div class="my-3">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link {{ $showDetail == 'docentes' ? 'active' : '' }}"
                    href="{{ route('disciplinas.show', ['disciplina' => $disciplina]) }}">Docentes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{ $showDetail == 'alunos' ? 'active' : '' }}"
                    href="{{ route('disciplinas.show', ['disciplina' => $disciplina, 'show-detail' => 'alunos']) }}">Alunos</a>
            </li>
        </ul>
    </div>

    <div>
        @if ($showDetail == 'docentes')
            <h3 class="my-3">Docentes que lecionam a disciplina</h3>
            @include('docentes.shared.table', [
                'docentes' => $disciplina->docentes,
                'showFoto' => true,
                'showDepartamento' => true,
                'showContatos' => true,
                'showDetail' => true,
                'showEdit' => false,
                'showDelete' => false,
            ])
        @elseif ($showDetail == 'alunos')
            <h3 class="my-3">Alunos inscritos à disciplina</h3>
            @include('alunos.shared.table', [
                'alunos' => $disciplina->alunos,
                'showFoto' => true,
                'showDepartamento' => false,
                'showContatos' => true,
                'showDetail' => true,
                'showEdit' => false,
                'showDelete' => false,
            ])
        @endif
    </div>

    @include('shared.confirmationDialog', [
        'title' => 'Apagar disciplina',
        'msgLine1' => 'Clique no botão "Apagar" para confirmar a operação',
        'msgLine2' => '',
        'confirmationButton' => 'Apagar',
        'formMethod' => 'DELETE',
    ])
@endsection
