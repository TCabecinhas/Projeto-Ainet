<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Curso;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CursoRequest;

class CursoController extends Controller
{
    public function index(): View
    {
        $allCursos = Curso::all();
        debug($allCursos);
        Log::debug('Cursos has been loaded on the controller.', ['$allCursos' => $allCursos]);
        return view('cursos.index')->with('cursos', $allCursos);
    }

    public function show(Curso $curso): View
    {
        $anos = $this->getDisciplinasOfCursoOrganizadas($curso);
        return view('cursos.show', compact('curso', 'anos'));
    }

    private function getDisciplinasOfCursoOrganizadas(Curso $curso): array
    {
        $disciplinasOfCurso = $curso->disciplinas;
        // $disciplinasOfCurso is a Eloquent Collection. Check:
        //https://laravel.com/docs/eloquent-collections
        $anosCurso = $disciplinasOfCurso->sortBy('ano')->pluck('ano')->unique();
        $anos = [];
        foreach ($anosCurso as $ano) {
            $anos[$ano] = [
                1 => $disciplinasOfCurso->sortBy('semestre')->sortBy('nome')->where('ano', $ano)->whereIn('semestre', [0, 1]),
                2 => $disciplinasOfCurso->sortBy('semestre')->sortBy('nome')->where('ano', $ano)->whereIn('semestre', [0, 2]),
            ];
        }
        return $anos;
    }

    public function planoCurricular(Curso $curso): View
    {
        $cursos = Curso::pluck('abreviatura');
        $anos = $this->getDisciplinasOfCursoOrganizadas($curso);
        return view('planos_curriculares.index', compact('cursos', 'curso', 'anos'));
    }

    public function create(): View
    {
        $newCurso = new Curso();
        return view('cursos.create')->withCurso($newCurso);
    }

    public function store(CursoRequest $request): RedirectResponse
    {
        $newCurso = Curso::create($request->validated());
        $url = route('cursos.show', ['curso' => $newCurso]);
        $htmlMessage = "Curso <a href='$url'>{$newCurso->abreviatura}</a>
                        <strong>\"{$newCurso->nome}\"</strong> foi criado com sucesso!";
        return redirect()->route('cursos.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function edit(Curso $curso): View
    {
        return view('cursos.edit')->withCurso($curso);
    }

    public function update(CursoRequest $request, Curso $curso): RedirectResponse
    {
        $curso->update($request->validated());
        $url = route('cursos.show', ['curso' => $curso]);
        $htmlMessage = "Curso <a href='$url'>{$curso->abreviatura}</a>
                        <strong>\"{$curso->nome}\"</strong> foi alterada com sucesso!";
        return redirect()->route('cursos.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function destroy(Curso $curso): RedirectResponse
    {
        try {
            $totalDisciplinas = DB::scalar('select count(*) from disciplinas where curso = ?', [$curso->abreviatura]);
            $totalAlunos = DB::scalar('select count(*) from alunos where curso = ?', [$curso->abreviatura]);
            $totalCandidaturas = DB::scalar('select count(*) from candidaturas where curso = ?', [$curso->abreviatura]);
            $url = route('cursos.show', ['curso' => $curso]);
            if ($totalDisciplinas == 0 && $totalAlunos == 0 && $totalCandidaturas == 0) {
                $curso->delete();
                $htmlMessage = "Curso {$curso->abreviatura}
                        <strong>\"{$curso->nome}\"</strong> foi apagado com sucesso!";
                return redirect()->route('cursos.index')
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', 'success');
            } else {
                $alertType = 'warning';
                $disciplinaStr = $totalDisciplinas > 0 ?
                    ($totalDisciplinas == 1 ?
                        "1 disciplina associada ao curso" :
                        "$totalDisciplinas disciplinas associadas ao curso") :
                    "";
                $alunoStr = $totalAlunos > 0 ?
                    ($totalAlunos == 1 ?
                        "1 aluno inscrito no curso" :
                        "$totalAlunos alunos inscritos no curso") :
                    "";
                $candidaturaStr = $totalCandidaturas > 0 ?
                    ($totalCandidaturas == 1 ?
                        "1 candidatura ao curso" :
                        "$totalCandidaturas candidaturas ao curso") :
                    "";
                $htmlMessage = "Curso <a href='$url'>{$curso->abreviatura}</a>
                        <strong>\"{$curso->nome}\"</strong>
                        não pode ser apagado ";
                if ($disciplinaStr && $alunoStr && $candidaturaStr) {
                    $htmlMessage .= "porque há $disciplinaStr, $alunoStr e $candidaturaStr!";
                } else {
                    if ($disciplinaStr && $alunoStr) {
                        $htmlMessage .= "porque há $disciplinaStr e $alunoStr!";
                    } elseif ($disciplinaStr && $candidaturaStr) {
                        $htmlMessage .= "porque há $disciplinaStr e $candidaturaStr!";
                    } elseif ($alunoStr && $candidaturaStr) {
                        $htmlMessage .= "porque há $alunoStr e $candidaturaStr!";
                    } else {
                        $htmlMessage .= "porque há $disciplinaStr $alunoStr $candidaturaStr!";
                    }
                }
            }
        } catch (\Exception $error) {
            $url = route('cursos.show', ['curso' => $curso]);
            $htmlMessage = "Não foi possível apagar o curso <a href='$url'>{$curso->abreviatura}</a>
                        <strong>\"{$curso->nome}\"</strong> porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }
}
