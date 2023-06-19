@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Criar Imagem">
        <form action="{{ route('dashboard.tshirtImages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="file-img">Imagem:</label>
                <input type="file" id="file-img" class="form-control" name="file">
            </div>

            <div class="form-group">
                <label for="txt-nome">Nome:</label>
                <input type="text" name="name" id="txt-nome" class="form-control">
            </div>

            <div class="form-group">
                <label for="sel-categoria">Categoria:</label>
                <select name="category_id" id="sel-categoria" class="form-control">
                    <option value="" selected>Sem categoria</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="txt-descricao">Descrição:</label>
                <textarea style="resize:none;" name="description" id="txt-descricao" cols="30" rows="10" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Criar Imagem</button>
                <a href="{{ route('dashboard.tshirtImages.index') }}" class="btn btn-outline-dark">Cancelar</a>
            </div>
        </form>
    </x-dashboard-card>
@endsection
