<!-- resources/views/images/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Editar Image: {{ $image->name }}</h1>

    <form action="{{ route('images.update', $image->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="customer_id">Customer ID:</label>
        <input type="text" name="customer_id" id="customer_id" value="{{ $image->customer_id }}">

        <label for="category_id">Category ID:</label>
        <input type="text" name="category_id" id="category_id" value="{{ $image->category_id }}">

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="{{ $image->name }}">

        <label for="description">Description:</label>
        <input type="text" name="description" id="description" value="{{ $image->description }}">

        <label for="image_url">Image URL:</label>
        <input type="text" name="image_url" id="image_url" value="{{ $image->image_url }}">

        <label for="extra_info">Extra Info:</label>
        <input type="text" name="extra_info" id="extra_info" value="{{ $image->extra_info }}">

        <button type="submit">Update Image</button>
    </form>

@endsection
