@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Utilizadores">
        <div class="mb-3">
            <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-dark"><i class="fa fa-arrow-left"></i> Todos os utilizadores</a>
        </div>

        <table class="table table-responsive-md table-responsive-sm table-hover table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Bloqueado</th>
                    <th>Data de eliminação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->tipo == 'C' ? 'Cliente' : ($u->tipo == 'A' ? 'Administrador' : 'Funcionário') }}</td>
                        <td>{{ $u->bloqueado ? 'Sim' : 'Não'}}</td>
                        <td>{{ date('Y-m-d', strtotime($u->deleted_at)) }}</td>
                        <td>
                            {{-- Restaurar --}}
                            <button type="submit" form="form_restore_{{ $u->id }}" class="btn btn-sm btn-outline-dark"><i class="fa fa-undo"></i></button>

                            <form action="{{ route('dashboard.users.restore', $u->id)}}" id="form_restore_{{ $u->id }}" method="POST">
                                @csrf
                                @method('put')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </x-dashboard-card>
@endsection
