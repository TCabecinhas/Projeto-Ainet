@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Utilizadores">
        <div class="mb-3">
            <a href="{{ route('dashboard.users.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Novo
                Utilizador</a>
            <a href="{{ route('dashboard.users.apagados') }}" class="btn btn-outline-dark"><i class="fa fa-recycle"></i>
                Utilizadores Apagados</a>
        </div>

        <div class="mb-3">
            <form action="{{ route('dashboard.users.index') }}" method="get" class="form-group">
                <div class="input-group mb-3">
                    <select name="user_type" class="custom-select">
                        <option value="*" {{ !$user_type ? 'selected' : '' }}>Todos</option>
                        <option value="A" {{ $user_type == 'A' ? 'selected' : '' }}>Administrador</option>
                        <option value="E" {{ $user_type == 'E' ? 'selected' : '' }}>Funcionário</option>
                        <option value="C" {{ $user_type == 'C' ? 'selected' : '' }}>Cliente</option>
                    </select>
                    <div class="input-group-append">
                        <input type="submit" value="Filtrar" class="btn btn-outline-dark">
                    </div>
                </div>
            </form>
        </div>

        <table class="table table-responsive-md table-responsive-sm table-hover table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Bloqueado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->user_type == 'C' ? 'Cliente' : ($u->user_type == 'A' ? 'Administrador' : 'Funcionário') }}</td>
                        <td>{{ $u->blocked ? 'Sim' : 'Não' }}</td>
                        <td>
                            {{-- Ver --}}
                            <a href="{{ route('dashboard.users.view', $u) }}" class="btn btn-sm btn-outline-primary"><i
                                    class="fa fa-eye"></i></a>

                            {{-- Editar --}}
                            @if ($u->user_type != 'C')
                                <a href="{{ route('dashboard.users.edit', $u) }}"
                                    class="btn btn-sm btn-outline-warning"><i class="fa fa-pencil-alt"></i></a>
                            @endif

                            {{-- Bloquear --}}
                            <button type="submit" form="form_block_{{ $u->id }}"
                                class="btn btn-sm btn-outline-dark"><i
                                    class="fa {{ $u->blocked ? 'fa-unlock' : 'fa-lock' }}"></i></button>

                            {{-- Eliminar --}}
                            <button type="submit" form="form_destroy_{{ $u->id }}"
                                class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                            <form action="{{ route('dashboard.users.destroy', $u) }}"
                                id="form_destroy_{{ $u->id }}" method="POST">
                                @csrf
                                @method('delete')
                            </form>


                            @if (!$u->blocked)
                                <form action="{{ route('dashboard.users.block', $u) }}"
                                    id="form_block_{{ $u->id }}" method="POST">
                                    @csrf
                                    @method('put')
                                </form>
                            @else
                                <form action="{{ route('dashboard.users.unblock', $u) }}"
                                    id="form_block_{{ $u->id }}" method="POST">
                                    @csrf
                                    @method('put')
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </x-dashboard-card>
@endsection
