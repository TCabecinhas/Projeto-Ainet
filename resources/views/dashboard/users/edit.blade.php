@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Editar utilizador">
        <form action="{{ route('dashboard.users.update', $user) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="txt-nome">Nome:</label>
                <input type="text" class="form-control" name="name" id="txt-nome" aria-describedby="nome" value="{{ $user->name }}">
            </div>

            <div class="form-group">
                <label for="txt-email">Email:</label>
                <input type="email" class="form-control" name="email" id="txt-email" aria-describedby="email" value="{{ $user->email }}">
            </div>

            <div class="form-group">
                <label for="sel-tipo">Tipo:</label>
                <select name="tipo" id="sel-tipo" class="form-control">
                    <option value="C" {{ $user->tipo == 'C' ? 'selected' : ''}}>Cliente</option>
                    <option value="A" {{ $user->tipo == 'A' ? 'selected' : ''}}>Administrador</option>
                    <option value="F" {{ $user->tipo == 'F' ? 'selected' : ''}}>Funcionário</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Alterar Utilizador</button>
            <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-dark">Cancelar</a>
        </form>
    </x-dashboard-card>
@endsection
