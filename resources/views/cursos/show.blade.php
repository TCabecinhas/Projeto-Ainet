@extends('template.layout')

@section('titulo', 'Curso')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Gestão</li>
        <li class="breadcrumb-item">Curricular</li>
        <li class="breadcrumb-item"><a href="{{ route('cursos.index') }}">Cursos</a></li>
        <li class="breadcrumb-item"><strong>{{ $curso->nome }}</strong></li>
        <li class="breadcrumb-item active">Consultar</li>
    </ol>
@endsection

@section('main')
    <div>
        @include('cursos.shared.fields', ['readonlyData' => true])
    </div>
    <div class="my-4 d-flex justify-content-end">
        <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal"
            data-bs-target="#confirmationModal"
            data-msgLine1="Quer realmente apagar o curso <strong>&quot;{{ $curso->nome }}&quot;</strong>?"
            data-action="{{ route('cursos.destroy', ['curso' => $curso]) }}">
            Apagar Curso
        </button>
        <a href="{{ route('cursos.edit', ['curso' => $curso]) }}" class="btn btn-secondary ms-3">Alterar Curso</a>
    </div>
    <div>
        <h3>Plano curricular do curso</h3>
        @include('planos_curriculares.shared.plano', ['anos' => $anos])
    </div>
    @include('shared.confirmationDialog', [
        'title' => 'Apagar curso',
        'msgLine1' => 'Clique no botão "Apagar" para confirmar a operação',
        'msgLine2' => '',
        'confirmationButton' => 'Apagar',
        'formMethod' => 'DELETE',
    ])
@endsection
