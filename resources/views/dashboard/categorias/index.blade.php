@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Categorias">
        <div class="mb-3">
            <a href="{{ route('dashboard.categorias.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Nova
                Categoria</a>
        </div>
        <table class="table table-responsive-md table-responsive-sm table-hover table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ $c->name }}</td>
                        <td>
                            {{-- Editar --}}
                            <a href="{{ route('dashboard.categorias.edit', $c) }}" class="btn btn-sm btn-outline-warning"><i
                                    class="fa fa-pencil-alt"></i></a>

                            {{-- Eliminar --}}
                            <button type="submit" form="form_destroy_{{ $c->id }}"
                                class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                            <form action="{{ route('dashboard.categorias.destroy', $c) }}"
                                id="form_destroy_{{ $c->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $categorias->links() }}
    </x-dashboard-card>
@endsection
