@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Editar Categoria ">
        <form action="{{ route('dashboard.categorias.update', $categoria) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="txt-nome">Nome:</label>
                <input type="text" class="form-control" name="nome" id="txt-nome" aria-describedby="nome"
                    value="{{ $categoria->name }}">
            </div>

            <button type="submit" class="btn btn-success">Alterar Categoria</button>
            <a href="{{ route('dashboard.categorias.index') }}" class="btn btn-outline-dark">Cancelar</a>
        </form>
    </x-dashboard-card>
@endsection
