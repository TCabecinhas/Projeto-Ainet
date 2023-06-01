<!-- resources/views/images/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h3>{{ $image->name }}</h3>
    <p>Customer ID: {{ $image->customer_id }}</p>
    <p>Category ID: {{ $image->category_id }}</p>
    <p>Description: {{ $image->description }}</p>
    <p>Image URL: {{ $image->image_url }}</p>
    <p>Extra Info: {{ $image->extra_info }}</p>

    <a href="{{ route('images.edit', ['image' => $image->id]) }}" class="btn btn-primary">Editar</a>
    <form action="{{ route('images.destroy', $image->id) }}" method="POST" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Excluir</button>
    </form>
@endsection
