@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Checkout:</h1>
        <form action="{{ route('carrinho.encomendar') }}" method="POST" class="row">
            @csrf
            @method('POST')
            <div class="form-group mb-4">
                <label for="txt-nif">NIF:</label>
                <input type="text" class="form-control" name="nif" id="txt-nif" aria-describedby="nif"
                    value="{{ isset(Auth::user()->cliente->nif) ? Auth::user()->cliente->nif : '' }}">
            </div>

            <div class="form-group mb-4">
                <label for="txt-endereco">Morada:</label>
                <input type="text" class="form-control" name="endereco" id="txt-endereco" aria-describedby="endereco"
                    value="{{ isset(Auth::user()->cliente->address) ? Auth::user()->cliente->address : '' }}">
            </div>


            <div class="form-group mb-4">
                <label for="select-tipo_pagamento">Método de pagamento:</label>
                <select class="form-control" name="tipo_pagamento" id="txt-tipo_pagamento"
                    aria-describedby="tipo_pagamento">
                    <option {{ !isset(Auth::user()->cliente->default_payment_type) ? 'selected' : '' }}></option>
                    <option value="VISA"
                        {{ isset(Auth::user()->cliente->default_payment_type) && Auth::user()->cliente->default_payment_type == 'VISA' ? 'selected' : '' }}>
                        VISA</option>
                    <option value="MC"
                        {{ isset(Auth::user()->cliente->default_payment_type) && Auth::user()->cliente->default_payment_type == 'MC' ? 'selected' : '' }}>
                        MC</option>
                    <option value="PAYPAL"
                        {{ isset(Auth::user()->cliente->default_payment_type) && Auth::user()->cliente->default_payment_type == 'PAYPAL' ? 'selected' : '' }}>
                        PAYPAL</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="txt-notas">Notas:</label>
                <textarea class="form-control"style="resize: none;" name="notas" id="txt-notas" cols="30" rows="10"></textarea>
            </div>

            <button type="submit" class="btn btn-block btn-outline-dark">Finalizar Encomenda</button>

        </form>
    </div>
@endsection
