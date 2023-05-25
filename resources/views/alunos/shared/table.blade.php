<table class="table">
    <thead class="table-dark">
        <tr>
            @if ($showFoto)
                <th></th>
            @endif
            <th>Nº</th>
            <th>Nome</th>
            <th>Curso</th>
            @if ($showDetail)
                <th class="button-icon-col"></th>
            @endif
            @if ($showEdit)
                <th class="button-icon-col"></th>
            @endif
            @if ($showDelete)
                <th class="button-icon-col"></th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($alunos as $aluno)
            <tr>
                @if ($showFoto)
                    <td width="45">
                        @if ($aluno->user->url_foto)
                            <img src="{{ $aluno->user->fullPhotoUrl }}" alt="Avatar" class="bg-dark rounded-circle"
                                width="45" height="45">
                        @endif
                    </td>
                @endif
                <td>{{ $aluno->numero }}</td>
                <td>{{ $aluno->user->name }}</td>
                <td>{{ $aluno->cursoRef->nome ?? '' }}</td>
                @if ($showDetail)
                    <td class="button-icon-col"><a class="btn btn-secondary"
                            href="{{ route('alunos.show', ['aluno' => $aluno]) }}">
                            <i class="fas fa-eye"></i></a></td>
                @endif
                @if ($showEdit)
                    <td class="button-icon-col"><a class="btn btn-dark"
                            href="{{ route('alunos.edit', ['aluno' => $aluno]) }}">
                            <i class="fas fa-edit"></i></a></td>
                @endif
                @if ($showDelete)
                    <td class="button-icon-col">
                        <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#confirmationModal"
                            data-msgLine1="Quer realmente apagar o aluno <strong>&quot;{{ $aluno->user->name }}&quot;</strong>?"
                            data-action="{{ route('alunos.destroy', ['aluno' => $aluno]) }}">
                            <i class="fas fa-trash"></i></button>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
@if ($showDelete)
    @include('shared.confirmationDialog', [
        'title' => 'Apagar aluno',
        'msgLine1' => 'Clique no botão "Apagar" para confirmar a operação',
        'msgLine2' => '',
        'confirmationButton' => 'Apagar',
        'formMethod' => 'DELETE',
    ])
@endif
