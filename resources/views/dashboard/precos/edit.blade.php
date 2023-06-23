@extends('layouts.dashboard')
@section('content')
    <x-dashboard-card title="Editar Preçario">
        <form action="{{ route('dashboard.precos.update', $precos) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="num-unit_price_catalog">Preço unitário tshirt catálogo:</label>
                <input type="number" class="form-control" name="unit_price_catalog" id="num-unit_price_catalog"
                    aria-describedby="unit_price_catalog" value="{{ $precos->unit_price_catalog }}">
            </div>
            <div class="form-group">
                <label for="num-unit_price_own">Preço unitário tshirt personalizada:</label>
                <input type="number" class="form-control" name="unit_price_own" id="num-unit_price_own"
                    aria-describedby="unit_price_own" value="{{ $precos->unit_price_own }}">
            </div>
            <div class="form-group">
                <label for="num-unit_price_catalog_discount">Preço unitário tshirt catálogo desconto:</label>
                <input type="number" class="form-control" name="unit_price_catalog_discount"
                    id="num-unit_price_catalog_discount" aria-describedby="unit_price_catalog_discount"
                    value="{{ $precos->unit_price_catalog_discount }}">
            </div>
            <div class="form-group">
                <label for="num-unit_price_own_discount">Preço unitário tshirt personalizada com desconto:</label>
                <input type="number" class="form-control" name="unit_price_own_discount"
                    id="num-unit_price_own_discount" aria-describedby="unit_price_own_discount"
                    value="{{ $precos->unit_price_own_discount }}">
            </div>
            <div class="form-group">
                <label for="num-qty_discount">Quantidade desconto:</label>
                <input type="number" class="form-control" name="qty_discount" id="num-qty_discount"
                    aria-describedby="qty_discount" value="{{ $precos->qty_discount }}">
            </div>
            <button type="submit" class="btn btn-success">Alterar Preço(s)</button>
        </form>
    </x-dashboard-card>
@endsection