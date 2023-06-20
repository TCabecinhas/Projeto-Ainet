@extends('layouts.app')

@push('css')
    <style>
        .img-box img {
            /* float: left; */
            width: auto;
            height: 200px;
        }

        .title {
            margin-bottom: 5vh
        }

        .card {
            margin: auto;
            width: 90%;
            box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 1rem;
            border: transparent
        }

        @media(max-width:767px) {
            .card {
                margin: 3vh auto
            }
        }

        .cart {
            background-color: #fff;
            padding: 4vh 5vh;
            border-bottom-left-radius: 1rem;
            border-top-left-radius: 1rem
        }

        @media(max-width:767px) {
            .cart {
                padding: 4vh;
                border-bottom-left-radius: unset;
                border-top-right-radius: 1rem
            }
        }

        .summary {
            background-color: #ddd;
            border-top-right-radius: 1rem;
            border-bottom-right-radius: 1rem;
            padding: 4vh;
            color: rgb(65, 65, 65)
        }

        @media(max-width:767px) {
            .summary {
                border-top-right-radius: unset;
                border-bottom-left-radius: 1rem
            }
        }

        .summary .col-2 {
            padding: 0
        }

        .summary .col-10 {
            padding: 0
        }

        .row {
            margin: 0
        }

        .title b {
            font-size: 1.5rem
        }

        .main {
            margin: 0;
            padding: 2vh 0;
            width: 100%
        }

        .col-2,
        .col {
            padding: 0 1vh
        }

        .card a {
            padding: 0 1vh
        }

        .close {
            margin-left: auto;
            /* font-size: 0.7rem */
        }

        .card img {
            width: 3.5rem
        }

        .back-to-shop {
            margin-top: 4.5rem
        }

        .card h5 {
            margin-top: 4vh
        }

        .card hr {
            margin-top: 1.25rem
        }



        .card select {
            border: 1px solid rgba(0, 0, 0, 0.137);
            padding: 1.5vh 1vh;
            margin-bottom: 4vh;
            outline: none;
            width: 100%;
            background-color: rgb(247, 247, 247)
        }



        .btn {
            background-color: #000;
            border-color: #000;
            color: white;
            width: 100%;
            /* font-size: 0.7rem; */
            margin-top: 4vh;
            padding: 1vh;
            border-radius: 0
        }

        .btn:focus {
            box-shadow: none;
            outline: none;
            box-shadow: none;
            color: white;
            -webkit-box-shadow: none;
            -webkit-user-select: none;
            transition: none
        }

        .btn:hover {
            color: white
        }

        a {
            color: black
        }

        a:hover {
            color: black;
            text-decoration: none
        }

        #code {
            background-image: linear-gradient(to left, rgba(255, 255, 255, 0.253), rgba(255, 255, 255, 0.185)), url("https://img.icons8.com/small/16/000000/long-arrow-right.png");
            background-repeat: no-repeat;
            background-position-x: 95%;
            background-position-y: center
        }
    </style>
@endpush

@section('content')
    <div class="card mt-4">
        <div class="row">
            <div class="col-md-9 cart">
                <div class="title">
                    <div class="row">
                        <div class="col">
                            <h4><b>{{ $carrinho ? 'Carrinho' : 'O carrinho está vazio' }}</b></h4>
                        </div>
                    </div>
                </div>
                @foreach ($carrinho as $i => $tshirt)
                    <div class="row border-top border-bottom">
                        <div class="row main align-items-center">
                            <div class="col-md-3">
                                <img class="img-fluid" height="150px"
                                    src="{{ $tshirt->personalizada ? url('/tshirtImages/image/' . $tshirt->tshirtImage->image_url) : asset('storage/tshirtImages/' . $tshirt->tshirtImage->image_url) }}"
                                    alt="{{ $tshirt->tshirtImage->name }}">
                                <img class="img-fluid ml-3" height="150px"
                                    src="{{ asset('storage/tshirt_base/') . '/' . $tshirt->cor_codigo . '.jpg' }}"
                                    alt="{{ $tshirt->cor_codigo }}">
                            </div>
                            <div class="col">
                                <div class="row text-muted">
                                    <span>{{ $tshirt->personalizada ? 'T-shirt Personalizada' : 'Catálogo' }}</span>
                                    <div class="d-flex flex-column">
                                        <span>Tamanho: {{ $tshirt->tamanho }}</span>
                                    </div>
                                </div>

                            </div>
                            <div class="col"> Quantidade: {{ $tshirt->quantidade }}</div>
                            <div class="col">
                                {{ $tshirt->quantidade . ' x ' . $tshirt->preco_un . '€ = ' . $tshirt->subtotal }}
                                €</div>
                            <div class="col">
                                <a
                                    href="{{ $tshirt->personalizada ? route('tshirts.editar-personalizada', $i) : route('tshirts.editar-tshirt-catalogo', $i) }}"><i
                                        class="fa fa-pencil mb-1 align-items-center "></i></a>
                                <a href="{{ route('tshirts.eliminar-tshirt', $i) }}"><i
                                        class="fa fa-trash mb-1 text-danger mr-3 px-2"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="back-to-shop"><a href="{{ route('index') }}">&leftarrow;<span class="text-muted">Continuar a
                            comprar</span></a></div>
            </div>
            <div class="col-md-3 summary">
                <div>
                    <h5><b>Checkout</b></h5>
                </div>
                <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                    <div class="col">TOTAL: {{ $total }} €</div>
                    <div class="col text-right"></div>
                </div>
                <div class="d-grid gap-2">
                    @if ($carrinho)
                        @auth
                            @can('is-client')
                                <a href="{{ route('carrinho.checkout') }}"
                                    class="btn btn-outline-dark btn-block btn-lg ml-2 pay-button">Efetuar Encomenda</a>
                            @endcan
                        @endauth
                    @endif

                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-dark btn-block btn-lg ml-2 pay-button">Tem de
                            estar autenticado para efetuar encomenda</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
@endsection
