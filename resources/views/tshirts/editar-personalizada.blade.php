@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <form action="{{ route('tshirts.atualizar-personalizada', $index) }}" method="POST" class="row" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label" for="file-tshirtImage">Insira o ficheiro da tshirtImage (Ou deixe em branco se pretender manter):</label>
                <input class="form-control" type="file" id="file-tshirtImage" name="file">
            </div>
            <div class="mb-3">
                <label for="select-cor" class="form-label">Cor:</label>
                <select class="form-select" id="select-cor" name="cor_codigo" aria-label="Lista de cores">
                    @foreach ($cores as $cor)
                        <option style="color: #{{ $cor->codigo }}; background: #{{ $cor->codigo }}" value="{{ $cor->codigo }}" {{ $tshirt->cor_codigo == $cor->codigo ? "selected" : "" }} >{{ $cor->nome }}</option>
                    @endforeach
                  </select>
            </div>
            <div class="mb-3">
                <label for="select-tamanho" class="form-label">Tamanho:</label>
                <select class="form-select" id="select-tamanho" name="tamanho" aria-label="Lista de tamanhos">
                    <option value="XS" {{ $tshirt->tamanho == "XS" ? "selected" : ""}}>XS</option>
                    <option value="S" {{ $tshirt->tamanho == "S" ? "selected" : ""}}>S</option>
                    <option value="M" {{ $tshirt->tamanho == "M" ? "selected" : ""}}>M</option>
                    <option value="L" {{ $tshirt->tamanho == "L" ? "selected" : ""}}>L</option>
                    <option value="XL" {{ $tshirt->tamanho == "XL" ? "selected" : ""}}>XL</option>
                  </select>
            </div>
            <input type="hidden" name="tshirtImage_id" value="{{ $tshirt->tshirtImage->id }}">
            <div class="mb-3">
                <label for="number-quantidade" class="form-label">Quantidade:</label>
                <input type="number" class="form-control" min="1" step="1" value="{{ $tshirt->quantidade }}" id="number-quantidade" name="quantidade">
            </div>
            <div class="mb-3">
                <input type="submit" value="Colocar no carrinho" class="btn btn-outline-dark">
            </div>
        </form>
    </div>
@endsection
