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
            <h1>ImagineShirts | Recibo de Encomenda</h1>
        </div>

        <div class="mb-3">
            <p><b>Cliente:</b>
                {{ isset($encomenda->cliente->user) ? $encomenda->cliente->user->name : '(utilizador removido)' }}</p>
            <p><b>Data:</b> {{ $encomenda->date }}</p>
            <p><b>Total:</b> {{ $encomenda->total_price }}€</p>
            <p><b>NIF:</b> {{ $encomenda->nif }}</p>
            <p><b>Endereço:</b> {{ $encomenda->address }}</p>

            @if ($encomenda->notes)
                <p><b>Notas:</b> {{ $encomenda->notes }}</p>
            @endif

            <p><b>Método de pagamento:</b> {{ $encomenda->payment_type }}</p>
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
                            <img class="img-fluid img-thumbnail" width="250px"
                                src="{{ $tshirt->tshirtImage->customer_id ? url('/tshirtImages/image/' . $tshirt->tshirtImage->image_url) : asset('storage/tshirtImages/' . $tshirt->tshirtImage->image_url) }}"
                                alt="{{ $tshirt->tshirtImage->name }}">
                        </td>
                        <td>
                            <img class="img-fluid ml-3" width="250px"
                                src="{{ asset('storage/tshirt_base/') . '/' . $tshirt->color_code . '.jpg' }}"
                                alt="{{ $tshirt->color_code }}">
                        </td>
                        <td>{{ $tshirt->size }}</td>
                        <td>{{ $tshirt->qty }}</td>
                        <td>{{ $tshirt->unit_price }} x {{ $tshirt->qty }} = {{ $tshirt->sub_total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
