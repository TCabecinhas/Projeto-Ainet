@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Nova Cor">
        <form action="{{ route('dashboard.cores.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="txt-codigo">Codigo:</label>
                <input type="text" class="form-control" name="codigo" id="txt-codigo" aria-describedby="codigo"
                    value="">
            </div>

        <div class="form-group">
            <label for="txt-nome">Nome:</label>
            <input type="text" class="form-control" name="nome" id="txt-nome" aria-describedby="nome"
                value="">
        </div>

            <button type="submit" class="btn btn-success">Criar Cor</button>
            <a href="{{ route('dashboard.cores.index') }}" class="btn btn-outline-dark">Cancelar</a>
        </form>
    </x-dashboard-card>
@endsection
