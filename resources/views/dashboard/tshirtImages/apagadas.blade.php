@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Imagens Apagadas">
        <div class="mb-3">
            <a href="{{ route('dashboard.tshirtImages.index') }}" class="btn btn-outline-dark"><i class="fa fa-arrow-left"></i>
                Todas as Imagens das Tshirts</a>
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
                        <td>{{ $tshirtImage->category ? $tshirtImage->category->name : '-' }}</td>
                        <td>
                            {{-- Restaurar --}}
                            <button type="submit" class="btn btn-sm btn-outline-dark"
                                form="form_restore_{{ $tshirtImage->id }}"><i class="fa fa-undo"></i></button>
                        </td>
                    </tr>

                    <form id="form_restore_{{ $tshirtImage->id }}"
                        action="{{ route('dashboard.tshirtImages.restore', $tshirtImage->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                    </form>
                @endforeach
            </tbody>
        </table>
        {{ $tshirtImages->links() }}
    </x-dashboard-card>
@endsection
