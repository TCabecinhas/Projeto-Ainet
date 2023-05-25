<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\User;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\AlunoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $cursos = Curso::all();
        $filterByCurso = $request->curso ?? '';
        $filterByNome = $request->nome ?? '';
        $alunoQuery = Aluno::query();
        if ($filterByCurso !== '') {
            $alunoQuery->where('curso', $filterByCurso);
        }
        if ($filterByNome !== '') {
            $userIds = User::where('name', 'like', "%$filterByNome%")->pluck('id');
            $alunoQuery->whereIntegerInRaw('user_id', $userIds);
        }
        // ATENÇÃO: Comparar estas 2 alternativas com Laravel Telescope
        //$alunos = $alunoQuery->paginate(10);
        $alunos = $alunoQuery->with('cursoRef', 'user')->paginate(10);
        return view('alunos.index', compact('alunos', 'cursos', 'filterByCurso', 'filterByNome'));
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    public function create(): View
    {
        $aluno = new Aluno();
        $user = new User();
        // Garante que atribute user existe (mas não grava nada na BD)
        // É necessário, para reaproveitar os forms,
        // porque o form para edit pressupoe que user existe
        $aluno->user = $user;
        // Curso default
        $aluno->curso = 'EI';
        $cursos = Curso::all();
        return view('alunos.create', compact('aluno', 'cursos'));
    }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    public function store(AlunoRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        $aluno = DB::transaction(function () use ($formData, $request) {
            $newUser = new User();
            $newUser->tipo = 'D';
            $newUser->name = $formData['name'];
            $newUser->email = $formData['email'];
            $newUser->admin = $formData['admin'];
            $newUser->genero = $formData['genero'];
            $newUser->password = Hash::make($formData['password_inicial']);
            $newUser->save();
            $newAluno = new Aluno();
            $newAluno->user_id = $newUser->id;
            $newAluno->curso = $formData['curso'];
            $newAluno->numero = $formData['numero'];
            $newAluno->save();
            if ($request->hasFile('file_foto')) {
                $path = $request->file_foto->store('public/fotos');
                $newUser->url_foto = basename($path);
                $newUser->save();
            }
            return $newAluno;
        });
        $url = route('alunos.show', ['aluno' => $aluno]);
        $htmlMessage = "Aluno <a href='$url'>#{$aluno->id}</a>
                        <strong>\"{$aluno->user->name}\"</strong> foi criada com sucesso!";
        return redirect()->route('alunos.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    // /**
    //  * Display the specified resource.
    //  */
    public function show(Aluno $aluno): View
    {
        $cursos = Curso::all();
        $aluno->load('disciplinas', 'disciplinas.cursoRef');
        return view('alunos.show', compact('aluno', 'cursos'));
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    public function edit(Aluno $aluno): View
    {
        $cursos = Curso::all();
        return view('alunos.edit', compact('aluno', 'cursos'));
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    public function update(AlunoRequest $request, Aluno $aluno): RedirectResponse
    {
        $formData = $request->validated();
        $aluno = DB::transaction(function () use ($formData, $aluno, $request) {
            $aluno->curso = $formData['curso'];
            $aluno->numero = $formData['numero'];
            $aluno->save();
            $user = $aluno->user;
            $user->tipo = 'D';
            $user->name = $formData['name'];
            $user->email = $formData['email'];
            $user->admin = $formData['admin'];
            $user->genero = $formData['genero'];
            $user->save();
            if ($request->hasFile('file_foto')) {
                if ($user->url_foto) {
                    Storage::delete('public/fotos/' . $user->url_foto);
                }
                $path = $request->file_foto->store('public/fotos');
                $user->url_foto = basename($path);
                $user->save();
            }
            return $aluno;
        });
        $url = route('alunos.show', ['aluno' => $aluno]);
        $htmlMessage = "Aluno <a href='$url'>#{$aluno->id}</a>
                        <strong>\"{$aluno->user->name}\"</strong> foi alterado com sucesso!";
        return redirect()->route('alunos.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    public function destroy(Aluno $aluno): RedirectResponse
    {
        try {
            $totalDisciplinas = DB::scalar('select count(*) from alunos_disciplinas where aluno_id = ?', [$aluno->id]);
            $user = $aluno->user;
            if ($totalDisciplinas == 0) {
                DB::transaction(function () use ($aluno, $user) {
                    $aluno->delete();
                    $user->delete();
                });
                if ($user->url_foto) {
                    Storage::delete('public/fotos/' . $user->url_foto);
                }
                $htmlMessage = "Aluno #{$aluno->id}
                        <strong>\"{$user->name}\"</strong> foi apagado com sucesso!";
                return redirect()->route('alunos.index')
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', 'success');
            } else {
                $url = route('alunos.show', ['aluno' => $aluno]);
                $alertType = 'warning';
                $disciplinasStr = $totalDisciplinas > 0 ?
                    ($totalDisciplinas == 1 ?
                        "está inscrito a 1 disciplina" :
                        "está inscrito a $totalDisciplinas disciplinas") :
                    "";
                $htmlMessage = "Aluno <a href='$url'>#{$aluno->id}</a>
                    <strong>\"{$user->name}\"</strong>
                    não pode ser apagado porque $disciplinasStr!
                    ";
            }
        } catch (\Exception $error) {
            $url = route('alunos.show', ['aluno' => $aluno]);
            $htmlMessage = "Não foi possível apagar o aluno <a href='$url'>#{$aluno->id}</a>
                        <strong>\"{$user->name}\"</strong> porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function destroy_foto(Aluno $aluno): RedirectResponse
    {
        if ($aluno->user->url_foto) {
            Storage::delete('public/fotos/' . $aluno->user->url_foto);
            $aluno->user->url_foto = null;
            $aluno->user->save();
        }
        return redirect()->route('alunos.edit', ['aluno' => $aluno])
            ->with('alert-msg', 'Foto do aluno "' . $aluno->user->name . '" foi removida!')
            ->with('alert-type', 'success');
    }
}
