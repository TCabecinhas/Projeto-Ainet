<table class="table">
    <thead class="table-dark">
        <tr>
            <th>Nº</th>
            <th>Nome</th>
            <th>Curso</th>
            <th>Média</th>
            <th>>23</th>
            <th>Origem</th>
            @if ($showDetail)
                <th class="button-icon-col"></th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($candidaturas as $candidatura)
            <tr>
                <td>{{ $candidatura->id }}</td>
                <td>{{ $candidatura->nome }}</td>
                <td>{{ $candidatura->cursoRef->tipo }} - {{ $candidatura->cursoRef->nome }}</td>
                <td>{{ $candidatura->media }}</td>
                <td>{{ $candidatura->m23 ? 'Sim' : '' }}</td>
                <td>{{ $candidatura->origemDescription }}</td>
                @if ($showDetail)
                    <td class="button-icon-col"><a class="btn btn-secondary"
                            href="{{ route('candidaturas.show', ['candidatura' => $candidatura]) }}">
                            <i class="fas fa-eye"></i></a></td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
