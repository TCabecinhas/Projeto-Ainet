@extends('layouts.dashboard')
@section('content')
    <x-dashboard-card title="Editar Preçario">
        <form action="{{ route('dashboard.precos.update', $precos) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="num-preco_un_catalogo">Preço unitário tshirt catálogo:</label>
                <input type="number" class="form-control" name="preco_un_catalogo" id="num-preco_un_catalogo"
                    aria-describedby="preco_un_catalogo" value="{{ $precos->unit_price_catalog }}">
            </div>
            <div class="form-group">
                <label for="num-preco_un_proprio">Preço unitário tshirt personalizada:</label>
                <input type="number" class="form-control" name="preco_un_proprio" id="num-preco_un_proprio"
                    aria-describedby="preco_un_proprio" value="{{ $precos->unit_price_own }}">
            </div>
            <div class="form-group">
                <label for="num-preco_un_catalogo_desconto">Preço unitário tshirt catálogo desconto:</label>
                <input type="number" class="form-control" name="preco_un_catalogo_desconto"
                    id="num-preco_un_catalogo_desconto" aria-describedby="preco_un_catalogo_desconto"
                    value="{{ $precos->unit_price_catalog_discount }}">
            </div>
            <div class="form-group">
                <label for="num-preco_un_proprio_desconto">Preço unitário tshirt personalizada com desconto:</label>
                <input type="number" class="form-control" name="preco_un_proprio_desconto"
                    id="num-preco_un_proprio_desconto" aria-describedby="preco_un_proprio_desconto"
                    value="{{ $precos->unit_price_own_discount }}">
            </div>
            <div class="form-group">
                <label for="num-quantidade_desconto">Quantidade desconto:</label>
                <input type="number" class="form-control" name="quantidade_desconto" id="num-quantidade_desconto"
                    aria-describedby="quantidade_desconto" value="{{ $precos->qty_discount }}">
            </div>
            <button type="submit" class="btn btn-success">Alterar Preço(s)</button>
        </form>
    </x-dashboard-card>
@endsection
