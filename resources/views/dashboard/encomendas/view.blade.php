@extends('layouts.dashboard')

@push('css')
<style>
    .accordion .img-box img {
        /* float: left; */
        width: auto;
        height: 200px;
    }

    .accordion  .title {
        margin-bottom: 5vh
    }

    .accordion  .card {
        margin: auto;
        box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        border-radius: 1rem;
        border: transparent
    }

    @media(max-width:767px) {
        .accordion  .card {
            margin: 3vh auto
        }
    }

    .accordion  .cart {
        background-color: #fff;
        padding: 4vh 5vh;
        border-bottom-left-radius: 1rem;
        border-top-left-radius: 1rem
    }

    @media(max-width:767px) {
        .accordion  .cart {
            padding: 4vh;
            border-bottom-left-radius: unset;
            border-top-right-radius: 1rem
        }
    }

    .accordion  .summary {
        background-color: #ddd;
        border-top-right-radius: 1rem;
        border-bottom-right-radius: 1rem;
        padding: 4vh;
        color: rgb(65, 65, 65)
    }

    @media(max-width:767px) {
        .accordion  .summary {
            border-top-right-radius: unset;
            border-bottom-left-radius: 1rem
        }
    }

    .accordion  .summary .col-2 {
        padding: 0
    }

    .accordion  .summary .col-10 {
        padding: 0
    }

   .row {
        margin: 0
    }

    .accordion  .title b {
        font-size: 1.5rem
    }

    .main {
        margin: 0;
        padding: 2vh 0;
        width: 100%
    }



    .accordion  .card a {
        padding: 0 1vh
    }

    .accordion  .close {
        margin-left: auto;
        /* font-size: 0.7rem */
    }

    .accordion .card img {
        width: 3.5rem
    }

    .accordion  #code {
        background-image: linear-gradient(to left, rgba(255, 255, 255, 0.253), rgba(255, 255, 255, 0.185)), url("https://img.icons8.com/small/16/000000/long-arrow-right.png");
        background-repeat: no-repeat;
        background-position-x: 95%;
        background-position-y: center
    }

</style>
@endpush

@section('content')
    <x-dashboard-card title="Consultar encomenda">
        <div class="form-group">
            <label for="txt-estado">Estado:</label>
            <input type="text" class="form-control" id="txt-estado" aria-describedby="nome" value="{{ $encomenda->estado }}" disabled>
        </div>

        <div class="form-group">
            <label for="txt-data">Data:</label>
            <input type="text" class="form-control" id="txt-data" aria-describedby="nome" value="{{ $encomenda->data }}" disabled>
        </div>

        <div class="form-group">
            <label for="txt-preco_total">Preço Total:</label>
            <input type="text" class="form-control" id="txt-preco_total" aria-describedby="nome" value="{{ $encomenda->preco_total }}€" disabled>
        </div>

        <div class="form-group">
            <label for="txt-notas">Notas:</label>
            <textarea id="txt-notas" class="form-control" style="resize:none" cols="30" rows="10" disabled>{{ $encomenda->notas }}</textarea>
        </div>

        <div class="form-group">
            <label for="txt-nif">NIF:</label>
            <input type="text" class="form-control" id="txt-nif" aria-describedby="nome" value="{{ $encomenda->nif }}" disabled>
        </div>

        <div class="form-group">
            <label for="txt-endereco">Endereço:</label>
            <input type="text" class="form-control" id="txt-endereco" aria-describedby="nome" value="{{ $encomenda->endereco }}" disabled>
        </div>

        <div class="form-group">
            <label for="txt-tipo_pagamento">Tipo de Pagamento:</label>
            <input type="text" class="form-control" id="txt-tipo_pagamento" aria-describedby="nome" value="{{ $encomenda->tipo_pagamento }}" disabled>
        </div>

        {{-- TSHIRTS --}}
        <div class="form-group">
            <div id="accordion">
                <div class="card">
                  <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                      <button class="btn" data-toggle="collapse" data-target="#tshirts-collapse" aria-expanded="false" aria-controls="tshirts-collapse">
                        <i class="fa fa-plus"></i> Tshirts
                      </button>
                    </h5>
                  </div>

                  <div id="tshirts-collapse" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        @foreach ($encomenda->tshirts as $tshirt)
                        <div class="row border-top border-bottom">
                            <div class="row main align-items-center">
                                <div class="col-md-4">
                                    <img class="img-fluid img-thumbnail" width="150px" src="{{ $tshirt->tshirtImage->cliente_id ? url('/tshirtImages/image/' . $tshirt->tshirtImage->imagem_url) : asset('storage/tshirtImages/'. $tshirt->tshirtImage->imagem_url) }}"
                                        alt="{{ $tshirt->tshirtImage->nome }}">
                                    <img class="img-fluid ml-3" width="150px"
                                        src="{{ asset('storage/tshirt_base/') . '/' . $tshirt->cor_codigo . '.jpg' }}"
                                        alt="{{ $tshirt->cor_codigo }}">
                                </div>
                                <div class="col">
                                    <div class="row text-muted d-flex flex-column">
                                        <span>{{ $tshirt->tshirtImage->cliente_id ? 'T-shirt Personalizada' : 'Catálogo' }}</span>
                                        <div>
                                            <span>Tamanho: {{ $tshirt->tamanho }}</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col"> Quantidade: {{ $tshirt->quantidade }}</div>
                                <div class="col">{{ $tshirt->quantidade . " x " . $tshirt->preco_un . "€ = " . $tshirt->subtotal }}
                                    €</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                  </div>
                </div>
            </div>
        </div>

        @can('recibo', $encomenda, 'App\Models\Encomenda')
            @if($encomenda->estado == 'fechada')
                <a href="{{ route('dashboard.encomendas.recibo', $encomenda) }}" class="btn btn-outline-danger">Ver recibo <i class="fa fa-file-pdf"></i></a>
            @endif
        @endcan

        <a href="{{ route('dashboard.encomendas.index') }}" class="btn btn-outline-dark">Voltar</a>
    </x-dashboard-card>
@endsection
