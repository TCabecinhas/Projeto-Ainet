<!-- resources/views/prices/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Prices</h1>

    <a href="{{ route('prices.create') }}" class="btn btn-primary">Criar Nova Price</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prices as $price)
                <tr>
                    <td>{{ $price->id }}</td>
                    <td>{{ $price->unit_price_catalog }}</td>
                    <td>{{ $price->unit_price_own }}</td>
                    <td>{{ $price->unit_price_catalog_discount }}</td>
                    <td>{{ $price->unit_price_own_discount }}</td>
                    <td>{{ $price->qty_discount }}</td>
                    <td>
                        <a href="{{ route('prices.show', $price->id) }}" class="btn btn-info">Detalhes</a>
                        <a href="{{ route('prices.edit', $price->id) }}" class="btn btn-primary">Editar</a>
                        <form action="{{ route('prices.destroy', $price->id) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
