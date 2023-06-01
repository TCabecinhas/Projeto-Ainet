<!-- resources/views/images/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Images</h1>

    <a href="{{ route('images.create') }}" class="btn btn-primary">Criar Nova Imagem</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Customer ID</th>
                <th>Category ID</th>
                <th>Description</th>
                <th>Image URL</th>
                <th>Extra Info</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($image as $image)
                <tr>
                    <td>{{ $image->id }}</td>
                    <td>{{ $image->name }}</td>
                    <td>{{ $image->customer_id }}</td>
                    <td>{{ $image->category_id }}</td>
                    <td>{{ $image->description }}</td>
                    <td>{{ $image->image_url }}</td>
                    <td>{{ $image->extra_info }}</td>
                    <td>
                        <a href="{{ route('images.show', $image->id) }}" class="btn btn-info">Detalhes</a>
                        <a href="{{ route('images.edit', $image->id) }}" class="btn btn-primary">Editar</a>
                        <form action="{{ route('images.destroy', $image->id) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
