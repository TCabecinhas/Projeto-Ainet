@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <form action="{{ route('tshirts.adicionar-personalizada-carrinho') }}" method="POST" class="row"
            enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="row mb-3">
                {{-- {{ dd($precos) }} --}}
                <p><b>Preço unitário de uma tshirt personalizada: </b><u>{{ $precos->unit_price_own }}€</u></p>
                <p><b>A partir de {{ $precos->qty_discount }} tshirts, o preço de cada tshirt baixa para
                    </b><u>{{ $precos->unit_price_own_discount }}€</u></p>
                <input value={{ $precos->unit_price_own }} class="form-control" type="hidden" id="preco" name="preco">
            </div>
            <div class="mb-3">
                <label class="form-label" for="file-tshirtImage">Insira o ficheiro da tshirtImage:</label>
                <input class="form-control" type="file" id="file-tshirtImage" name="file">
            </div>
            <div class="mb-3">
                <label class="form-label" for="txt-nome">Nome da tshirtImage:</label>
                <input class="form-control" type="text" id="txt-nome" name="nome">
            </div>
            <div class="mb-3">
                <label class="form-label" for="txt-descricao">Descrição da tshirtImage:</label>
                <textarea class="form-control"style="resize: none;" name="descricao" id="txt-descricao" cols="30" rows="10"></textarea>
            </div>
            <div class="mb-3">
                <p>Cor T-Shirt:</p>
                @foreach ($cores as $cor)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="cor_codigo" id="rd-cor"
                            value="{{ $cor->code }}"
                            style="background-color: #{{ $cor->code }};color:#{{ $cor->code }};
                                        height:2rem; width:2rem">
                    </div>
                @endforeach
            </div>
            <div class="mb-3">
                <label for="select-tamanho" class="form-label">Tamanho:</label>
                <select class="form-select" id="select-tamanho" name="tamanho" aria-label="Lista de tamanhos">
                    <option selected disabled>Selecione o tamanho da t-shirt</option>
                    <option value="XS">XS</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="number-quantidade" class="form-label">Quantidade:</label>
                <input type="number" class="form-control" min="1" step="1" value="1"
                    id="number-quantidade" name="quantidade">
            </div>
            <div class="mb-3">
                <input type="submit" value="Colocar no carrinho" class="btn btn-outline-dark">
            </div>
        </form>
    </div>
@endsection
