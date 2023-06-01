<!-- resources/views/colors/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Colors</h1>

    <a href="{{ route('colors.create') }}" class="btn btn-primary">Criar Nova Color</a>

    <table class="table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($color as $color)
                <tr>
                    <td>{{ $color->code }}</td> <!-- Esta linha está a causar erro, não aparecem os valores adequados na página-->
                    <td>{{ $color->name }}</td>
                    <td>
                        <a href="{{ route('colors.show', $color->code) }}" class="btn btn-info">Detalhes</a>
                        <a href="{{ route('colors.edit', $color->code) }}" class="btn btn-primary">Editar</a>
                        <form action="{{ route('colors.destroy', $color->code) }}" method="POST"
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
