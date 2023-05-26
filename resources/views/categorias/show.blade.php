<!-- resources/views/categorias/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Categoria: {{ $categoria->name }}</h1>

    <p>ID: {{ $categoria->id }}</p>
    <p>Nome: {{ $categoria->name }}</p>

    <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-primary">Editar</a>
    <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Excluir</button>
    </form>
@endsection
