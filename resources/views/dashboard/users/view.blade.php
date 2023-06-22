@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Consultar utilizador">

        <div class="mb-2 d-flex justify-content-center">
            <img class="img-thumbnail rounded-circle" width="200px"
                                            src="{{ $user->photo_url ? asset('storage/photos/' . $user->photo_url) : asset('img/default_img.png') }}">
        </div>

        <div class="form-group">
            <label for="txt-nome">Nome:</label>
            <input type="text" class="form-control" name="name" id="txt-nome" aria-describedby="nome" value="{{ $user->name }}" disabled>
        </div>

        <div class="form-group">
            <label for="txt-email">Email:</label>
            <input type="text" class="form-control" name="email" id="txt-email" aria-describedby="email" value="{{ $user->email }}" disabled>
        </div>

        <div class="form-group">
            <label for="txt-tipo">Tipo:</label>
            <input type="text" class="form-control" name="email" id="txt-email" aria-describedby="email" value="{{ $user->user_type == 'C' ? 'Cliente' : ($user->user_type == 'A' ? 'Administrador' : 'Funcionário') }}" disabled>
        </div>

        <div class="form-group">
            <label for="txt-tipo">Bloqueado:</label>
            <input type="text" class="form-control" name="tipo" id="txt-email" aria-describedby="tipo" value="{{ $user->blocked ? 'Sim' : 'Não' }}" disabled>
        </div>

        <div class="form-group">
            <label for="txt-tipo">Registado desde:</label>
            <input type="text" class="form-control" name="tipo" id="txt-email" aria-describedby="tipo" value="{{ date('Y-m-d', strtotime($user->created_at)) }}" disabled>
        </div>

        @if($user->user_type == 'C')
            <div class="form-group">
                <label for="txt-nif">NIF:</label>
                <input type="text" class="form-control" name="nif" id="txt-nif" aria-describedby="nif" value="{{ $user->cliente->nif }}" disabled>
            </div>

            <div class="form-group">
                <label for="txt-endereco">Morada:</label>
                <input type="text" class="form-control" name="endereco" id="txt-endereco" aria-describedby="endereco" value="{{ $user->cliente->endereco }}" disabled>
            </div>

            <div class="form-group">
                <label for="txt-tipo_pagamento">Tipo de pagamento:</label>
                <input type="text" class="form-control" name="tipo_pagamento" id="txt-tipo_pagamento" aria-describedby="tipo_pagamento" value="{{ $user->cliente->tipo_pagamento }}" disabled>
            </div>


        @endif

        <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-dark">Voltar</a>
    </x-dashboard-card>
@endsection
