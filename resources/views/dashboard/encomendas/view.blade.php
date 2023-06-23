@extends('layouts.dashboard')

@push('css')
    <style>

        .container {
            position: relative;
        }

        .imagem-1 {
            position: relative;
            z-index: 1;
            width: 150px !important;
        }

        .imagem-2 {
            position: absolute;
            width: 70px !important;
            top: 30px;
            left: 65px;
            z-index: 2;
        }

        .accordion .img-box img {
            /* float: left; */
            width: auto;
            height: 200px;
        }

        .accordion .title {
            margin-bottom: 5vh
        }

        .accordion .card {
            margin: auto;
            box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 1rem;
            border: transparent
        }

        @media(max-width:767px) {
            .accordion .card {
                margin: 3vh auto
            }
        }

        .accordion .cart {
            background-color: #fff;
            padding: 4vh 5vh;
            border-bottom-left-radius: 1rem;
            border-top-left-radius: 1rem
        }

        @media(max-width:767px) {
            .accordion .cart {
                padding: 4vh;
                border-bottom-left-radius: unset;
                border-top-right-radius: 1rem
            }
        }

        .accordion .summary {
            background-color: #ddd;
            border-top-right-radius: 1rem;
            border-bottom-right-radius: 1rem;
            padding: 4vh;
            color: rgb(65, 65, 65)
        }

        @media(max-width:767px) {
            .accordion .summary {
                border-top-right-radius: unset;
                border-bottom-left-radius: 1rem
            }
        }

        .accordion .summary .col-2 {
            padding: 0
        }

        .accordion .summary .col-10 {
            padding: 0
        }

        .row {
            margin: 0
        }

        .accordion .title b {
            font-size: 1.5rem
        }

        .main {
            margin: 0;
            padding: 2vh 0;
            width: 100%
        }



        .accordion .card a {
            padding: 0 1vh
        }

        .accordion .close {
            margin-left: auto;
            /* font-size: 0.7rem */
        }

        .accordion .card img {
            width: 3.5rem
        }

        .accordion #code {
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
            <input type="text" class="form-control" id="txt-estado" aria-describedby="nome" value="{{ $order->status }}"
                disabled>
        </div>

        <div class="form-group">
            <label for="txt-data">Data:</label>
            <input type="text" class="form-control" id="txt-data" aria-describedby="nome" value="{{ $order->date }}"
                disabled>
        </div>

        <div class="form-group">
            <label for="txt-preco_total">Preço Total:</label>
            <input type="text" class="form-control" id="txt-preco_total" aria-describedby="nome"
                value="{{ $order->total_price }}€" disabled>
        </div>

        <div class="form-group">
            <label for="txt-notas">Notas:</label>
            <textarea id="txt-notas" class="form-control" style="resize:none" cols="30" rows="10" disabled>{{ $order->notes }}</textarea>
        </div>

        <div class="form-group">
            <label for="txt-nif">NIF:</label>
            <input type="text" class="form-control" id="txt-nif" aria-describedby="nome" value="{{ $order->nif }}"
                disabled>
        </div>

        <div class="form-group">
            <label for="txt-endereco">Endereço:</label>
            <input type="text" class="form-control" id="txt-endereco" aria-describedby="nome"
                value="{{ $order->address }}" disabled>
        </div>

        <div class="form-group">
            <label for="txt-tipo_pagamento">Tipo de Pagamento:</label>
            <input type="text" class="form-control" id="txt-tipo_pagamento" aria-describedby="nome"
                value="{{ $order->payment_type }}" disabled>
        </div>

        {{-- TSHIRTS --}}
        <div class="form-group">
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn" data-toggle="collapse" data-target="#tshirts-collapse"
                                aria-expanded="false" aria-controls="tshirts-collapse">
                                <i class="fa fa-plus"></i> Tshirts
                            </button>
                        </h5>
                    </div>

                    <div id="tshirts-collapse" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            @foreach ($order->tshirts as $tshirt)
                                <div class="row border-top border-bottom">
                                    <div class="row main align-items-center">
                                        <div class="col-md-4">
                                            <div class="container">
                                                <img src="{{ $tshirt->personalizada ? url('/tshirtImages/image/' . $tshirt->tshirtImage->image_url) : asset('storage/tshirt_images/' . $tshirt->tshirtImage->image_url) }}"
                                                 alt="{{ $tshirt->tshirtImage->name }}" class="imagem-2">
                                                <img  src="{{ asset('storage/tshirt_base/') . '/' . $tshirt->color_code . '.jpg' }}" alt="{{ $tshirt->color_code }}" class="imagem-1">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row text-muted d-flex flex-column">
                                                <span>{{ $tshirt->tshirtImage->customer_id ? 'T-shirt Personalizada' : 'Catálogo' }}</span>
                                                <div>
                                                    <span>Tamanho: {{ $tshirt->size }}</span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col"> Quantidade: {{ $tshirt->qty }}</div>
                                        <div class="col">
                                            {{ $tshirt->qty . ' x ' . $tshirt->unit_price . '€ = ' . $tshirt->sub_total }}
                                            €</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @can('recibo', $order, 'App\Models\Encomenda')
            @if ($order->status == 'fechada')
                <a href="{{ route('dashboard.encomendas.recibo', $order) }}" class="btn btn-outline-danger">Ver recibo <i
                        class="fa fa-file-pdf"></i></a>
            @endif
        @endcan

        <a href="{{ route('dashboard.encomendas.index') }}" class="btn btn-outline-dark">Voltar</a>
    </x-dashboard-card>
@endsection
