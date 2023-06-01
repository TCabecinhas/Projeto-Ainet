<!-- resources/views/colors/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Color: {{ $color->name }}</h1>

    <p>ID: {{ $color->code }}</p>
    <p>Nome: {{ $color->name }}</p>

    <a href="{{ route('colors.edit', $color->code) }}" class="btn btn-primary">Editar</a>
    <form action="{{ route('colors.destroy', $color->code) }}" method="POST" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Excluir</button>
    </form>
@endsection
