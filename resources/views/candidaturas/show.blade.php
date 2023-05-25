@extends('template.layout')

@section('titulo', 'Candidatura')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Candidaturas</li>
        <li class="breadcrumb-item"><a href="{{ route('candidaturas.index') }}">Candidaturas</a></li>
        <li class="breadcrumb-item"><strong>#{{ $candidatura->id }}</strong></li>
        <li class="breadcrumb-item active">Consultar</li>
    </ol>
@endsection

@section('main')
    <div>
        @include('candidaturas.shared.fields', ['candidatura' => $candidatura, 'readonlyData' => true])
    </div>
@endsection
