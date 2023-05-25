@extends('template.layout')

@section('titulo', 'Departamentos')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Gestão</li>
        <li class="breadcrumb-item">Recursos Humanos</li>
        <li class="breadcrumb-item active">Departamentos</li>
    </ol>
@endsection

@section('main')
    <p><a class="btn btn-success" href="{{ route('departamentos.create') }}"><i class="fas fa-plus"></i> &nbsp;Criar novo
            departamento</a></p>
    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>Abreviatura</th>
                <th>Nome</th>
                <th class="button-icon-col"></th>
                <th class="button-icon-col"></th>
                <th class="button-icon-col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departamentos as $departamento)
                <tr>
                    <td>{{ $departamento->abreviatura }}</td>
                    <td>{{ $departamento->nome }}</td>
                    <td class="button-icon-col"><a class="btn btn-secondary"
                            href="{{ route('departamentos.show', ['departamento' => $departamento]) }}">
                            <i class="fas fa-eye"></i></a></td>
                    <td class="button-icon-col"><a class="btn btn-dark"
                            href="{{ route('departamentos.edit', ['departamento' => $departamento]) }}">
                            <i class="fas fa-edit"></i></a></td>
                    <td class="button-icon-col">
                        <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#confirmationModal"
                            data-msgLine1="Quer realmente apagar o departamento <strong>&quot;{{ $departamento->nome }}&quot;</strong>?"
                            data-action="{{ route('departamentos.destroy', ['departamento' => $departamento]) }}">
                            <i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @include('shared.confirmationDialog', [
        'title' => 'Apagar departamento',
        'msgLine1' => 'Clique no botão "Apagar" para confirmar a operação',
        'msgLine2' => '',
        'confirmationButton' => 'Apagar',
        'formMethod' => 'DELETE',
    ])

@endsection
