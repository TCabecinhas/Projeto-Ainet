@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Perfil">
        <div class="mb-2 d-flex justify-content-center">
            <img class="img-thumbnail rounded-circle" width="200px"
                                            src="{{ Auth::user()->foto_url ? asset('storage/fotos/' . Auth::user()->foto_url) : asset('img/default_img.png') }}">
        </div>
        <form action="{{ route('dashboard.users.atualizar-perfil', Auth::user()) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="txt-nome">Nome:</label>
                <input type="text" class="form-control" name="name" id="txt-nome" aria-describedby="nome" value="{{ Auth::user()->name }}">
            </div>

            <div class="form-group">
                <label for="txt-email">Email:</label>
                <input type="email" class="form-control" name="email" id="txt-email" aria-describedby="email" value="{{ Auth::user()->email }}">
            </div>

            <div class="form-group">
                <label for="file-avatar">Foto de perfil:</label>
                <input type="file" class="form-control" name="avatar" id="file-avatar" aria-describedby="avatar">
            </div>

            <div class="form-group">
                <label for="txt-password">Senha:</label>
                <input type="password" class="form-control" name="password" id="txt-password" aria-describedby="password">
            </div>

            <div class="form-group">
                <label for="txt-confirm-password">Confirmar senha:</label>
                <input type="password" class="form-control" name="password_confirmation" id="txt-password" aria-describedby="confirm-password">
            </div>

            @if(Auth::user()->tipo == 'C')
                <div class="form-group">
                    <label for="txt-nif">NIF:</label>
                    <input type="text" class="form-control" name="nif" id="txt-nif" aria-describedby="nif" value="{{ isset(Auth::user()->cliente->nif) ? Auth::user()->cliente->nif : '' }}">
                </div>

                <div class="form-group">
                    <label for="txt-endereco">Morada:</label>
                    <input type="text" class="form-control" name="endereco" id="txt-endereco" aria-describedby="endereco" value="{{ isset(Auth::user()->cliente->endereco) ? Auth::user()->cliente->endereco : '' }}">
                </div>

                <div class="form-group">
                    <label for="select-tipo_pagamento">Método de pagamento:</label>
                    <select class="form-control" name="tipo_pagamento" id="txt-tipo_pagamento" aria-describedby="tipo_pagamento">
                        <option {{ !isset(Auth::user()->cliente->tipo_pagamento) ? 'selected' : ''}}></option>
                        <option value="VISA" {{ isset(Auth::user()->cliente->tipo_pagamento) && Auth::user()->cliente->tipo_pagamento == 'VISA' ? 'selected' : '' }}>VISA</option>
                        <option value="MC" {{ isset(Auth::user()->cliente->tipo_pagamento) && Auth::user()->cliente->tipo_pagamento == 'MC' ? 'selected' : '' }}>MC</option>
                        <option value="PAYPAL" {{ isset(Auth::user()->cliente->tipo_pagamento) && Auth::user()->cliente->tipo_pagamento == 'PAYPAL' ? 'selected' : '' }}>PAYPAL</option>
                    </select>
                </div>
            @endif

            <button type="submit" class="btn btn-success">Alterar perfil</button>
            @if(Auth::user()->foto_url)
            <button type="submit" form="form_delete_photo" class="btn btn-outline-danger">Eliminar foto de perfil</button>
            @endif
            <a href="{{ route('dashboard.index') }}" class="btn btn-outline-dark">Cancelar</a>
        </form>
        @if(Auth::user()->foto_url)
            <form id="form_delete_photo" action="{{ route('users.apagar-foto', Auth::user()) }}" method="post">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </x-dashboard-card>
@endsection
