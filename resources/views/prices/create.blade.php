<!-- resources/views/prices/create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Criar Nova Price</h1>

    <form action="{{ route('prices.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Criar</button>
    </form>
@endsection
