@extends('template.layout')

@section('titulo', 'Alterar Departamento')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Gestão</li>
        <li class="breadcrumb-item">Recursos Humanos</li>
        <li class="breadcrumb-item"><a href="{{ route('departamentos.index') }}">Departamentos</a></li>
        <li class="breadcrumb-item"><strong>{{ $departamento->nome }}</strong></li>
        <li class="breadcrumb-item active">Alterar</li>
    </ol>
@endsection


@section('main')
    <form novalidate class="needs-validation" method="POST"
        action="{{ route('departamentos.update', ['departamento' => $departamento]) }}">
        @csrf
        @method('PUT')
        @include('departamentos.shared.fields')
        <div class="my-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" name="ok">Guardar Alterações</button>
            <a href="{{ route('departamentos.show', ['departamento' => $departamento]) }}"
                class="btn btn-secondary ms-3">Cancelar</a>
        </div>
    </form>
@endsection
