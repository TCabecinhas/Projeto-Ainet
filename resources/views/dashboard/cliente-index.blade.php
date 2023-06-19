@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card text-center">
                <div class="card-header">Imagens Privadas</div>
                <div class="card-body">
                    <h1>{{ $tshirtImages }}</h1>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card text-center">
                <div class="card-header">Encomendas</div>
                <div class="card-body">
                    <h1>{{ $encomendas }}</h1>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card text-center">
                <div class="card-header">Encomendas à Espera de Pagamento</div>
                <div class="card-body">
                    <h1>{{ $encomendas_por_pagar }}</h1>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card text-center">
                <div class="card-header">Encomendas em Progresso</div>
                <div class="card-body">
                    <h1>{{ $encomendas_em_espera }}</h1>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card text-center">
                <div class="card-header">Encomendas Finalizadas</div>
                <div class="card-body">
                    <h1>{{ $encomendas_finalizadas }}</h1>
                </div>
            </div>
        </div>

    </div>
@endsection
