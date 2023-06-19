<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo</title>
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">

        <div class="mb-3">
            <h1>MagicShirts | Recibo de Encomenda</h1>
        </div>

        <div class="mb-3">
            <p><b>Cliente:</b> {{ isset($encomenda->cliente->user) ? $encomenda->cliente->user->name : '(utilizador removido)' }}</p>
            <p><b>Data:</b> {{ $encomenda->data }}</p>
            <p><b>Total:</b> {{ $encomenda->preco_total }}€</p>
            <p><b>NIF:</b> {{ $encomenda->nif }}</p>
            <p><b>Endereço:</b> {{ $encomenda->endereco }}</p>

            @if($encomenda->notas)
                <p><b>Notas:</b> {{ $encomenda->notas }}</p>
            @endif

            <p><b>Método de pagamento:</b> {{ $encomenda->tipo_pagamento }}</p>
        </div>



        <table class="table text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Imagem</th>
                    <th>Cor</th>
                    <th>Tamanho</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($encomenda->tshirts as $tshirt)
                    <tr>
                        <td>
                            <img class="img-fluid img-thumbnail" width="250px" src="{{ $tshirt->tshirtImage->cliente_id ? url('/tshirtImages/image/' . $tshirt->tshirtImage->imagem_url) : asset('storage/tshirtImages/'. $tshirt->tshirtImage->imagem_url) }}"
                                        alt="{{ $tshirt->tshirtImage->nome }}">
                        </td>
                        <td>
                            <img class="img-fluid ml-3" width="250px"
                                        src="{{ asset('storage/tshirt_base/') . '/' . $tshirt->cor_codigo . '.jpg' }}"
                                        alt="{{ $tshirt->cor_codigo }}">
                        </td>
                        <td>{{ $tshirt->tamanho }}</td>
                        <td>{{ $tshirt->quantidade }}</td>
                        <td>{{ $tshirt->preco_un }} x {{ $tshirt->quantidade }} = {{ $tshirt->subtotal }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
