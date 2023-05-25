@extends('template.layout')

@section('titulo', 'Aluno')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('alunos.index') }}">Alunos</a></li>
        <li class="breadcrumb-item"><strong>{{ $aluno->user->name }}</strong></li>
        <li class="breadcrumb-item active">Consultar</li>
    </ol>
@endsection

@section('main')
    <div>
        <div class="d-flex flex-column flex-sm-row justify-content-start align-items-start">
            <div class="flex-grow-1 pe-2">
                @include('users.shared.fields', ['user' => $aluno->user, 'readonlyData' => true])
                @include('alunos.shared.fields', ['aluno' => $aluno, 'readonlyData' => true])
                <div class="my-1 d-flex justify-content-end">
                    <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#confirmationModal"
                        data-msgLine1="Quer realmente apagar o aluno <strong>&quot;{{ $aluno->user->name }}&quot;</strong>?"
                        data-action="{{ route('alunos.destroy', ['aluno' => $aluno]) }}">
                        Apagar Aluno
                    </button>
                    <a href="{{ route('alunos.edit', ['aluno' => $aluno]) }}" class="btn btn-secondary ms-3">
                        Alterar Aluno
                    </a>
                </div>
            </div>
            <div class="ps-2 mt-5 mt-md-1 d-flex mx-auto flex-column align-items-center justify-content-between"
                style="min-width:260px; max-width:260px;">
                @include('users.shared.fields_foto', [
                    'user' => $aluno->user,
                    'allowUpload' => false,
                    'allowDelete' => false,
                ])
            </div>
        </div>
    </div>
    <div>
        <h3>Disciplinas a que está inscrito</h3>
        @include('disciplinas.shared.table', [
            'disciplinas' => $aluno->disciplinas,
            'showCurso' => true,
            'showDetail' => true,
            'showEdit' => false,
            'showDelete' => false,
        ])
    </div>
    @include('shared.confirmationDialog', [
        'title' => 'Apagar aluno',
        'confirmationButton' => 'Apagar',
        'formMethod' => 'DELETE',
    ])

@endsection
