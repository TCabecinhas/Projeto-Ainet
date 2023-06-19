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
                            <img src="{{asset('storage/tshirtImages/'.$tshirt->tshirtImage->imagem_url)}}" class="img-fluid w-75 h-auto"
                                alt="{{$tshirt->tshirtImage->nome}}">
                        </div>
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <form action="{{ route('tshirts.atualizar-tshirt-catalogo', $index) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label class="form-label" for="number-quantidade">Quantidade:</label>
                                    <input type="number" class="form-control mb-4" min="1" step="1" value="{{ $tshirt->quantidade }}" id="number-quantidade" name="quantidade">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="rd-cor_codigo">Cor:</label>
                                    <br>
                                    @foreach ($cores as $cor)
                                        <div class="form-check form-check-inline">
                                            <input class="form-control form-check-input" type="radio" name="cor_codigo" id="rd-cor_codigo"
                                                value="{{$cor->codigo}}" style="background-color: #{{$cor->codigo}};color:#{{$cor->codigo}};
                                                    height:2rem; width:2rem" {{ $tshirt->cor_codigo == $cor->codigo ? 'checked' : '' }}>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-group mt-4">
                                    <label for="select-tamanho" class="form-label">Tamanho</label>
                                    <select class="form-control form-select" id="select-tamanho" name="tamanho"
                                        aria-label="Lista de tamanhos">
                                        <option value="XS" {{ $tshirt->tamanho == 'XS' ? 'selected' : '' }}>XS</option>
                                        <option value="S" {{ $tshirt->tamanho == 'S' ? 'selected' : '' }}>S</option>
                                        <option value="M" {{ $tshirt->tamanho == 'M' ? 'selected' : '' }}>M</option>
                                        <option value="L" {{ $tshirt->tamanho == 'L' ? 'selected' : '' }}>L</option>
                                        <option value="XL" {{ $tshirt->tamanho == 'XL' ? 'selected' : '' }}>XL</option>
                                    </select>
                                </div>
                                <div class="row mt-4">
                                    <button type="submit" class="btn btn-lg btn-block btn-outline-dark">
                                    <i class="fa fa-shopping-cart carrinho"></i> Adicionar ao Carrinho</button>
                                </div>
                            </form>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
