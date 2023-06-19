@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Editar Imagem">
        <form action="{{ route('dashboard.tshirtImages.update', $tshirtImage) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="file-img">Imagem (não preencher para manter):</label>
                <input type="file" id="file-img" class="form-control" name="file">
            </div>

            <div class="form-group">
                <label for="txt-nome">Nome:</label>
                <input type="text" name="name" id="txt-nome" class="form-control" value="{{ $tshirtImage->name }}">
            </div>

            <div class="form-group">
                <label for="sel-categoria">Categoria:</label>
                <select name="category_id" id="sel-categoria" class="form-control">
                    <option value="" {{ !$tshirtImage->category_id ? 'selected' : '' }}>Sem categoria</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $tshirtImage->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="txt-descricao">Descrição:</label>
                <textarea style="resize:none;" name="description" id="txt-descricao" cols="30" rows="10" class="form-control">{{ $tshirtImage->description }}</textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Alterar Imagem</button>
                <a href="{{ route('dashboard.tshirtImages.index') }}" class="btn btn-outline-dark">Cancelar</a>
            </div>
        </form>
    </x-dashboard-card>
@endsection
