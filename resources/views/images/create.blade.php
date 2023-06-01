<!-- resources/views/images/create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Criar Nova Imagem</h1>

    <form action="{{ route('images.store') }}" method="POST">
        @csrf
        <label for="customer_id">Customer ID:</label>
        <input type="text" name="customer_id" id="customer_id">

        <label for="category_id">Category ID:</label>
        <input type="text" name="category_id" id="category_id">

        <label for="name">Name:</label>
        <input type="text" name="name" id="name">

        <label for="description">Description:</label>
        <input type="text" name="description" id="description">

        <label for="image_url">Image URL:</label>
        <input type="text" name="image_url" id="image_url">

        <label for="extra_info">Extra Info:</label>
        <input type="text" name="extra_info" id="extra_info">

        <button type="submit">Create Image</button>
    </form>
@endsection
