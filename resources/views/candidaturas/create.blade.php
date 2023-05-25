@extends('template.layout')

@section('titulo', 'Nova Candidatura')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Candidaturas</li>
        <li class="breadcrumb-item active">Enviar Candidaturas</li>
        <li class="breadcrumb-item">Criar Nova</li>
    </ol>
@endsection

@section('main')
    <form method="POST" action="{{ route('candidaturas.store') }}">
        @csrf
        @include('candidaturas.shared.fields')
        <div class="my-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" name="ok">Enviar candidatura</button>
            <a href="{{ route('candidaturas.create') }}" class="btn btn-secondary ms-3">Cancelar</a>
        </div>
    </form>
@endsection
