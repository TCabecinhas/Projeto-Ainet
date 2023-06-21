@extends('layouts.dashboard')

@section('content')
    <x-dashboard-card title="Encomenda">
        <table class="table table-responsive-md table-responsive-sm  table-hover table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Estado</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Preço</th>
                    <th>Mét. Pagamento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($encomendas as $e)
                    <tr>
                        <td>{{ $e->id }}</td>
                        <td>{{ $e->status }}</td>
                        <td>{{ isset($e->cliente->user) ? $e->cliente->user->name : '(utilizador removido)' }}</td>
                        <td>{{ $e->date }}</td>
                        <td>{{ $e->total_price }}€</td>
                        <td>{{ $e->payment_type }}</td>
                        <td>
                            @if ($e->status == 'pendent')
                                @can('pay', $e, App\Models\Encomenda::class)
                                    <button type="submit" form="form_pay_{{ $e->id }}" class="btn btn-sm btn-outline-dark"
                                        data-toggle="tooltip" data-placement="top" title="Pagar Encomenda"><i
                                            class="fa fa-check"></i></button>
                                    <form class="d-none" action="{{ route('dashboard.encomendas.pay', $e) }}"
                                        id="form_pay_{{ $e->id }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                @endcan
                            @endif

                            @if ($e->status == 'paid')
                                @can('close', $e, App\Models\Encomenda::class)
                                    <button type="submit" form="form_close_{{ $e->id }}"
                                        class="btn btn-sm btn-outline-dark" data-toggle="tooltip" data-placement="top"
                                        title="Fechar Encomenda"><i class="fa fa-times-circle"></i></button>
                                    <form class="d-none" action="{{ route('dashboard.encomendas.close', $e) }}"
                                        id="form_close_{{ $e->id }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                @endcan
                            @endif

                            @can('cancel', $e, App\Models\Encomenda::class)
                                <button type="submit" form="form_cancel_{{ $e->id }}"
                                    class="btn btn-sm btn-outline-dark" data-toggle="tooltip" data-placement="top"
                                    title="Anular Encomenda"><i class="fa fa-ban"></i></button>
                                <form class="d-none" action="{{ route('dashboard.encomendas.cancel', $e) }}"
                                    id="form_cancel_{{ $e->id }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                </form>
                            @endcan


                            {{-- Ver --}}
                            <a href="{{ route('dashboard.encomendas.view', $e) }}" class="btn btn-sm btn-outline-primary"
                                data-toggle="tooltip" data-placement="top" title="Ver Encomenda"><i
                                    class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $encomendas->links() }}
    </x-dashboard-card>
@endsection
