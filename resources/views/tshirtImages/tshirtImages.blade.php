@extends('layouts.app')
@push('css')
    <style>
        .carrinho:hover {
            text-shadow: 2px 2px 5px black;
        }

        .box {
            border-radius: 15px;
            background-color: #faf9fa;
        }

        .box-img {
            width: auto;
            height: 200px;
            object-fit: scale-down;
        }

        .box a {
            text-decoration: none;
            color: black;
        }

        label {
            font-weight: bold;
        }
    </style>
@endpush
@section('content')
    <section class="mt-4">
        <div class="container">
            <div class="row mb-4">
                <div class="product">
                    <div class="container mb-4">
                        <div class="row">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 ">
                                <img src="{{ asset('storage/tshirtImages/' . $tshirtImage->image_url) }}"
                                    class="img-fluid w-75 h-auto" alt="{{ $tshirtImage->name }}">
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <h1>{{ $tshirtImage->name }}</h1>
                                <div class="mb-2 ">
                                    <h5>Categoria:
                                        <a
                                            href="{{ $tshirtImage->category_id && $tshirtImage->category ? route('tshirtImages.category', ['id' => $tshirtImage->categories->id]) : '#' }}">
                                            {{ $tshirtImage->category_id && $tshirtImage->category ? $tshirtImage->category : 'Sem categoria' }}
                                        </a>
                                    </h5>
                                </div>

                                <div class="mt-4">
                                    <p><b>Descrição:</b> {{ $tshirtImage->description }}</p>
                                </div>

                                <form action="{{ route('tshirts.adicionar-catalogo-carrinho', $tshirtImage) }}" @csrf
                                    @method('POST') <div class="form-group">
                                    <label class="form-label" for="number-quantidade">Quantidade:</label>
                                    <input type="number" class="form-control mb-4" min="1" step="1"
                                        value="1" id="number-quantidade" name="quantidade">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="rd-cor_codigo">Cor:</label>
                                <br>
                                @foreach ($colors as $color)
                                    <div class="form-check form-check-inline">
                                        <input class="form-control form-check-input" type="radio" name="cor_codigo"
                                            id="rd-cor_codigo" value="{{ $color->code }}"
                                            style="background-color: #{{ $color->code }};color:#{{ $color->code }};
                                                    height:2rem; width:2rem">
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group mt-4">
                                <label for="select-tamanho" class="form-label">Tamanho</label>
                                <select class="form-control form-select" id="select-tamanho" name="tamanho"
                                    aria-label="Lista de tamanhos">
                                    <option selected disabled>Selecione o tamanho da t-shirt</option>
                                    <option value="XS">XS</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                </select>
                            </div>
                            <div class="row mt-4">
                                <button type="submit" class="btn btn-lg btn-block btn-outline-dark">
                                    <i class="fa fa-shopping-cart carrinho"></i> Adicionar ao Carrinho
                                </button>
                            </div>
                            <div class="row mt-3">
                                <p><b>Preço unitário de uma tshirt: </b><u>{{ $prices->unit_price_catalog }}€</u>
                                </p>
                                <p><b>A partir de {{ $prices->qty_discount }} tshirts, o preço de cada tshirt
                                        baixa para </b><u>{{ $prices->unit_price_catalog_discount }}€</u></p>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <h2 class="text-center">Relacionados:</h2>
                <div class="row">
                    @foreach ($recommended as $recommended)
                        <x-tshirtImage-card :tshirtImage="$recommended" />
                    @endforeach
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
