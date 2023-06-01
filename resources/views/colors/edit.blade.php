<!-- resources/views/colors/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Editar Color: {{ $color->name }}</h1>

    <form action="{{ route('colors.update', ['color' => $color->code]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $color->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
@endsection
