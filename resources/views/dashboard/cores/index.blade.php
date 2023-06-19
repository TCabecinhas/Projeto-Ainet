@extends('layouts.dashboard')
@push('css')
<style>
    .dot {
        height: 30px;
        width: 30px;
        border-radius: 50%;
        display: inline-block;
    }

</style>

@endpush
@section('content')
<x-dashboard-card title="Cores">
    <div class="mb-3">
        <a href="{{ route('dashboard.cores.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Nova Cor</a>
    </div>
    <table class="table table-responsive-md table-responsive-sm table-hover table-bordered text-center">
        <thead class="thead-dark">
            <tr>
                <th>#Codigo</th>
                <th>Nome</th>
                <th>Ilustração</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cores as $c)
                <tr>
                    <td>{{ $c->codigo }}</td>
                    <td>{{ $c->nome }}</td>
                    <td><span class="dot" style="background-color: #{{ $c->codigo }}"></span></td>
                    <td>
                        {{-- Editar --}}
                        <a href="{{ route('dashboard.cores.edit', $c) }}" class="btn btn-sm btn-outline-warning"><i class="fa fa-pencil-alt"></i></a>

                        {{-- Eliminar --}}
                        <button type="submit" form="form_destroy_{{$c->codigo}}" class="btn btn-sm btn-outline-danger"><i
                                class="fa fa-trash"></i></button>
                        <form action="{{ route('dashboard.cores.destroy', $c) }}" id="form_destroy_{{$c->codigo}}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $cores->links() }}
</x-dashboard-card>
@endsection
