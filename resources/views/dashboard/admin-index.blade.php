@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="card text-center">
                <div class="card-header">Utilizadores</div>
                <div class="card-body">
                    <h1>{{ $utilizadores }}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="card text-center">
                <div class="card-header">Imagens no Catálogo</div>
                <div class="card-body">
                    <h1>{{ $catalogo }}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="card text-center">
                <div class="card-header">Clientes</div>
                <div class="card-body">
                    <h1>{{ $cliente }}</h1>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="card text-center">
                <div class="card-header">Funcionários</div>
                <div class="card-body">
                    <h1>{{ $funcionarios }}</h1>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="card text-center">
                <div class="card-header">Administradores</div>
                <div class="card-body">
                    <h1>{{ $admins }}</h1>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="card text-center">
                <div class="card-header">Encomendas</div>
                <div class="card-body">
                    <h1>{{ $encomendas }}</h1>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="card text-center {{ $encomendas_acao > 0 ? 'bg-danger text-light' : ''}}">
                <div class="card-header {{ $encomendas_acao > 0 ? 'bg-danger text-light' : ''}}">Encomendas à espera de ação:</div>
                <div class="card-body">
                    <h1>{{ $encomendas_acao }}</h1>
                    @if($encomendas_acao > 0)
                        <a href="{{ route('dashboard.encomendas.index') }}" class="btn btn-block btn-outline-light">Ações <i class="fa fa-arrow-right"></i></a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="card text-center">
                <div class="card-header">Categorias</div>
                <div class="card-body">
                    <h1>{{ $categorias }}</h1>
                </div>
            </div>
        </div>

    </div>
@endsection
