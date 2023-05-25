@extends('template.layout')

@section('titulo', 'Planos Curriculares')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Planos Curriculares</li>
        <li class="breadcrumb-item">{{ $curso->tipo }}</li>
        <li class="breadcrumb-item active">{{ $curso->nome }}</li>
    </ol>
@endsection

@section('main')
    <ul class="nav nav-pills">
        @foreach ($cursos as $abreviatura)
            <li class="nav-item">
                <a class="nav-link {{ $abreviatura == $curso->abreviatura ? 'active' : '' }}"
                    href="{{ route('cursos.plano_curricular', ['curso' => $abreviatura]) }}">{{ $abreviatura }}</a>
            </li>
        @endforeach
    </ul>
    @include('planos_curriculares.shared.plano', ['anos' => $anos])
@endsection
