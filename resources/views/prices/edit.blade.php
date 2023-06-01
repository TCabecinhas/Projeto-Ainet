<!-- resources/views/prices/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Editar Price: {{ $price->name }}</h1>

    <form action="{{ route('prices.update', $price->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $price->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
@endsection
