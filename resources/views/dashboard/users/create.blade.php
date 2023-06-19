@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Novo utilizador">
        <form action="{{ route('dashboard.users.store') }}" method="post">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="txt-nome">Nome:</label>
                <input type="text" class="form-control" name="name" id="txt-nome" aria-describedby="nome" value="">
            </div>

            <div class="form-group">
                <label for="txt-email">Email:</label>
                <input type="email" class="form-control" name="email" id="txt-email" aria-describedby="email" value="">
            </div>

            <div class="form-group">
                <label for="txt-password">Password:</label>
                <input type="password" class="form-control" name="password" id="txt-password" aria-describedby="password" value="">
            </div>

            <div class="form-group">
                <label for="txt-password_confirmation">Confirmar password:</label>
                <input type="password" class="form-control" name="password_confirmation" id="txt-password_confirmation" aria-describedby="password_confirmation" value="">
            </div>

            <div class="form-group">
                <label for="sel-tipo">Tipo:</label>
                <select name="tipo" id="sel-tipo" class="form-control">
                    <option value="C">Cliente</option>
                    <option value="A">Administrador</option>
                    <option value="F">Funcionário</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Criar Utilizador</button>
            <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-dark">Cancelar</a>
        </form>
    </x-dashboard-card>
@endsection
