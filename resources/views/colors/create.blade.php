<!-- resources/views/colors/create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Criar Nova Color</h1>

    <form action="{{ route('colors.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" name="name" code="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Criar</button>
    </form>
@endsection
