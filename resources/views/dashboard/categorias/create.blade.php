@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Nova Categoria">
        <form action="{{ route('dashboard.categorias.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="txt-nome">Nome:</label>
                <input type="text" class="form-control" name="nome" id="txt-nome" aria-describedby="nome"
                    value="">
            </div>
            <button type="submit" class="btn btn-success">Criar Categoria</button>
            <a href="{{ route('dashboard.categorias.index') }}" class="btn btn-outline-dark">Cancelar</a>
        </form>
    </x-dashboard-card>
@endsection
