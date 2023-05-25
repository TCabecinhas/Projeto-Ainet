<table class="table">
    <thead class="table-dark">
        <tr>
            <th>Abreviatura</th>
            <th>Nome</th>
            @if ($showCurso)
                <th>Curso</th>
            @endif
            <th>Ano</th>
            <th>Semestre</th>
            @if ($showDetail)
                <th class="button-icon-col"></th>
            @endif
            @if ($showEdit)
                <th class="button-icon-col"></th>
            @endif
            @if ($showDelete)
                <th class="button-icon-col"></th>
            @endif
            @if ($showAddCart ?? false)
                <th class="button-icon-col"></th>
            @endif
            @if ($showRemoveCart ?? false)
                <th class="button-icon-col"></th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($disciplinas as $disciplina)
            <tr>
                <td>{{ $disciplina->abreviatura }}</td>
                <td>{{ $disciplina->nome }}</td>
                @if ($showCurso)
                    <td>{{ $disciplina->cursoRef->tipo }} - {{ $disciplina->cursoRef->nome }}</td>
                @endif
                <td>{{ $disciplina->ano }}</td>
                <td>{{ $disciplina->semestreStr }}</td>
                @if ($showDetail)
                    <td class="button-icon-col"><a class="btn btn-secondary"
                            href="{{ route('disciplinas.show', ['disciplina' => $disciplina]) }}">
                            <i class="fas fa-eye"></i></a></td>
                @endif
                @if ($showEdit)
                    <td class="button-icon-col"><a class="btn btn-dark"
                            href="{{ route('disciplinas.edit', ['disciplina' => $disciplina]) }}">
                            <i class="fas fa-edit"></i></a></td>
                @endif
                @if ($showDelete)
                    <td class="button-icon-col">
                        <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#confirmationModal"
                            data-msgLine1="Quer realmente apagar a disciplina <strong>&quot;{{ $disciplina->nome }}&quot;</strong>?"
                            data-action="{{ route('disciplinas.destroy', ['disciplina' => $disciplina]) }}">
                            <i class="fas fa-trash"></i></button>
                    </td>
                @endif
                @if ($showAddCart ?? false)
                    <td class="button-icon-col">
                        <form method="POST" action="{{ route('cart.add', ['disciplina' => $disciplina]) }}">
                            @csrf
                            <button type="submit" name="addToCart" class="btn btn-success">
                                <i class="fas fa-plus"></i></button>
                        </form>
                    </td>
                @endif
                @if ($showRemoveCart ?? false)
                    <td class="button-icon-col">
                        <form method="POST" action="{{ route('cart.remove', ['disciplina' => $disciplina]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" name="removeFromCart" class="btn btn-danger">
                                <i class="fas fa-remove"></i></button>
                        </form>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>

@if ($showDelete)
    @include('shared.confirmationDialog', [
        'title' => 'Apagar disciplina',
        'msgLine1' => 'Clique no botão "Apagar" para confirmar a operação',
        'msgLine2' => '',
        'confirmationButton' => 'Apagar',
        'formMethod' => 'DELETE',
    ])
@endif
