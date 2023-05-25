@foreach ($anos as $ano => $semestres)
    <h5 class="text-center mt-3 bg-dark text-light py-2">{{ $ano }}º ano</h5>
    <div class="d-flex">
        @foreach ($semestres as $semestre => $disciplinas)
            <div class="flex-grow-1">
                <table class="table">
                    <thead class="table-secondary">
                        <tr>
                            <th colspan="4">{{ $semestre }}º semestre</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($disciplinas as $disciplina)
                            <tr>
                                <td>{{ $disciplina->abreviatura }}</td>
                                <td>{{ $disciplina->nome }}</td>
                                <td class="button-icon-col"><a class="btn btn-secondary"
                                        href="{{ route('disciplinas.show', ['disciplina' => $disciplina]) }}">
                                        <i class="fas fa-eye"></i></a></td>
                                <td class="button-icon-col">
                                    <form method="POST"
                                        action="{{ route('cart.add', ['disciplina' => $disciplina]) }}">
                                        @csrf
                                        <button type="submit" name="addToCart" class="btn btn-success">
                                            <i class="fas fa-plus"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($loop->first)
                <div style="width:20px">
                </div>
            @endif
        @endforeach
    </div>
@endforeach
