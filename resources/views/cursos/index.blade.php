@extends('template.layout')

@section('titulo', 'Cursos')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Gestão</li>
        <li class="breadcrumb-item">Curricular</li>
        <li class="breadcrumb-item active">Cursos</li>
    </ol>
@endsection

@section('main')
    <p>
        <a class="btn btn-success" href="{{ route('cursos.create') }}"><i class="fas fa-plus"></i> &nbsp;Criar novo curso</a>
    </p>
    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>Abreviatura</th>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Nº Semestres</th>
                <th>Nº Vagas</th>
                <th class="button-icon-col"></th>
                <th class="button-icon-col"></th>
                <th class="button-icon-col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursos as $curso)
                <tr>
                    <td>{{ $curso->abreviatura }}</td>
                    <td>{{ $curso->nome }}</td>
                    <td>{{ $curso->tipo }}</td>
                    <td>{{ $curso->semestres }}</td>
                    <td>{{ $curso->vagas }}</td>
                    <td class="button-icon-col"><a href="{{ route('cursos.show', ['curso' => $curso]) }}"
                            class="btn btn-secondary"><i class="fas fa-eye"></i></a></td>
                    <td class="button-icon-col"><a href="{{ route('cursos.edit', ['curso' => $curso]) }}"
                            class="btn btn-dark"><i class="fas fa-edit"></i></a></td>
                    <td class="button-icon-col">
                        <form method="POST" action="{{ route('cursos.destroy', ['curso' => $curso]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" name="delete" class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection