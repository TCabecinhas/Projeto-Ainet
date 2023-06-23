@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 ">
            <img src="{{ asset('storage/tshirt_Privadas/' . $tshirt->imagem['image_url']) }}"
                class="img-fluid w-75 h-auto" alt="{{ $tshirt->image->name }}">
        </div>
        <form action="{{ route('tshirts.atualizar-personalizada', $index) }}" method="POST" class="row"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label" for="file-tshirtImage">Insira o ficheiro da tshirtImage (Ou deixe em branco se
                    pretender manter):</label>
                <input class="form-control" type="file" id="file-tshirtImage" name="file">
            </div>
            <div class="mb-3">
                <label for="select-cor" class="form-label">Cor:</label>
                @foreach ($cores as $cor)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="cor_codigo" id="rd-cor"
                            value="{{ $cor->code }}"
                            style="background-color: #{{ $cor->code }};color:#{{ $cor->code }};
                                        height:2rem; width:2rem">
                    </div>
                @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="select-tamanho" class="form-label">Tamanho:</label>
                <select class="form-select" id="select-tamanho" name="tamanho" aria-label="Lista de tamanhos">
                    <option value="XS" {{ $tshirt->tamanho == 'XS' ? 'selected' : '' }}>XS</option>
                    <option value="S" {{ $tshirt->tamanho == 'S' ? 'selected' : '' }}>S</option>
                    <option value="M" {{ $tshirt->tamanho == 'M' ? 'selected' : '' }}>M</option>
                    <option value="L" {{ $tshirt->tamanho == 'L' ? 'selected' : '' }}>L</option>
                    <option value="XL" {{ $tshirt->tamanho == 'XL' ? 'selected' : '' }}>XL</option>
                </select>
            </div>
            <input type="hidden" name="tshirtImage_id" value="{{ $tshirt->tshirtImage->id }}">
            <div class="mb-3">
                <label for="number-quantidade" class="form-label">Quantidade:</label>
                <input type="number" class="form-control" min="1" step="1" value="{{ $tshirt->quantidade }}"
                    id="number-quantidade" name="quantidade">
            </div>
            <div class="mb-3">
                <input type="submit" value="Colocar no carrinho" class="btn btn-outline-dark">
            </div>
        </form>
    </div>
@endsection
