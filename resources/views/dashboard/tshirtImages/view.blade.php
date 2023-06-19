@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Ver Imagem">
        <div class="mb-3 d-flex justify-content-center">
            <img class="img-thumbnail" width="200px"
                src="{{ $tshirtImage->customer_id ? url('/tshirtImages/image/' . $tshirtImage->image_url) : asset('storage/tshirtImages/' . $tshirtImage->image_url) }}">
        </div>

        <div class="form-group">
            <label for="txt-categoria">Categoria:</label>
            <input type="text" id="txt-categoria" class="form-control"
                value="{{ $tshirtImage->category ? $tshirtImage->category->name : '-' }}" disabled>
        </div>

        <div class="form-group">
            <label for="txt-nome">Nome:</label>
            <input type="text" id="txt-nome" class="form-control" value="{{ $tshirtImage->name }}" disabled>
        </div>

        <div class="form-group">
            <label for="txt-descricao">Descrição:</label>
            <textarea style="resize:none;" id="txt-descricao" cols="30" rows="10" class="form-control" disabled>{{ $tshirtImage->description }}</textarea>
        </div>

        <div class="form-group">
            <a href="{{ route('dashboard.tshirtImages.index') }}" class="btn btn-secondary">Voltar</a>
            <a href="{{ route('dashboard.tshirtImages.edit', $tshirtImage) }}" class="btn btn-outline-warning"><i
                    class="fa fa-pencil-alt"></i> Editar Imagem</a>
            <button type="submit" class="btn btn-outline-danger" form="form_delete_tshirtImage"><i
                    class="fa fa-trash-alt"></i> Eliminar Imagem</button>
        </div>

        <form action="{{ route('dashboard.tshirtImages.destroy', $tshirtImage) }}" method="post"
            id="form_delete_tshirtImage">
            @csrf
            @method('DELETE')
        </form>
    </x-dashboard-card>
@endsection
