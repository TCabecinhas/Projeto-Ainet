<!-- resources/views/prices/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Editar Price: </h1>

    <form action="{{ route('prices.update', $price->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="id">unit_price_catalog</label>
            <input type="text" name="unit_price_catalog" id="unit_price_catalog" class="form-control"
                value="{{ $price->unit_price_catalog }}" required>

            <label for="id">unit_price_own</label>
            <input type="text" name="unit_price_own" id="unit_price_own" class="form-control"
                value="{{ $price->unit_price_own }}" required>


        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
@endsection
