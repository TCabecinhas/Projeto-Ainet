<!-- resources/views/prices/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Price: {{ $price->name }}</h1>

    <p>ID: {{ $price->id }}</p>
    <p>Teste: {{ $price->name }}</p>

    <a href="{{ route('prices.edit', $price->id) }}" class="btn btn-primary">Editar</a>
    <form action="{{ route('prices.destroy', $price->id) }}" method="POST" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Excluir</button>
    </form>
@endsection
