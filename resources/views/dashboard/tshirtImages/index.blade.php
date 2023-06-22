@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Imagens">
        <div class="mb-3">
            <a href="{{ route('dashboard.tshirtImages.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Nova
                Imagem de Tshirt</a>
            <a href="{{ route('dashboard.tshirtImages.apagadas') }}" class="btn btn-outline-dark"><i class="fa fa-recycle"></i>
                Imagens de Tshirt Apagadas</a>
        </div>
        <table class="table table-responsive-md table-responsive-sm table-hover table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tshirtImages as $tshirtImage)
                    <tr>
                        <td>{{ $tshirtImage->id }}</td>
                        <td>{{ $tshirtImage->name }}</td>
                        <td>{{ $tshirtImage->category_name ? $tshirtImage->category_name : '-' }}</td>
                        <td>
                            {{-- Ver --}}
                            <a href="{{ route('dashboard.tshirtImages.view', $tshirtImage->id) }}"
                                class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"></i></a>

                            {{-- Editar --}}
                            <a href="{{ route('dashboard.tshirtImages.edit', $tshirtImage->id) }}"
                                class="btn btn-sm btn-outline-warning"><i class="fa fa-pencil-alt"></i></a>

                            {{-- Eliminar --}}
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                form="form_delete_{{ $tshirtImage->id }}"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>

                    <form id="form_delete_{{ $tshirtImage->id }}"
                        action="{{ route('dashboard.tshirtImages.destroy', $tshirtImage->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                @endforeach
            </tbody>
        </table>
        {{ $tshirtImages->links() }}
    </x-dashboard-card>
@endsection
