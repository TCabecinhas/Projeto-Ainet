@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Editar Cor ">
        <form action="{{ route('dashboard.cores.update', $cor) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="txt-codigo">Codigo:</label>
                <input type="text" class="form-control" name="codigo" id="txt-codigo" aria-describedby="codigo"
                    value="{{ $cor->code }}">
            </div>

            <div class="form-group">
                <label for="txt-nome">Nome:</label>
                <input type="text" class="form-control" name="nome" id="txt-email" aria-describedby="nome"
                    value="{{ $cor->nome }}">
            </div>

            <button type="submit" class="btn btn-success">Alterar Cor</button>
            <a href="{{ route('dashboard.cores.index') }}" class="btn btn-outline-dark">Cancelar</a>
        </form>
    </x-dashboard-card>
@endsection
