<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidatura;
use App\Models\Curso;
use App\Models\CandidaturaEstatuto;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\CandidaturaRequest;
use Illuminate\Support\Facades\DB;

class CandidaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $cursos = Curso::all();
        $filterByCurso = $request->curso ?? '';
        $candidaturaQuery = Candidatura::query();
        if ($filterByCurso !== '') {
            $candidaturaQuery->where('curso', $filterByCurso);
        }
        $candidaturas = $candidaturaQuery->orderBy('id', 'desc')->paginate(10);
        return view('candidaturas.index', compact('candidaturas', 'cursos', 'filterByCurso'));
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    public function create(): View
    {
        $candidatura = new Candidatura();
        $cursos = Curso::all();
        return view('candidaturas.create', compact('candidatura', 'cursos'));
    }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    public function store(CandidaturaRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        $candidatura = DB::transaction(function () use ($formData) {
            $newCandidatura = new Candidatura();
            $newCandidatura->curso = $formData['curso'];
            $newCandidatura->nome = $formData['nome'];
            $newCandidatura->email = $formData['email'];
            $newCandidatura->telefone1 = $formData['telefone1'];
            $newCandidatura->telefone2 = $formData['telefone2'];
            $newCandidatura->genero = $formData['genero'];
            $newCandidatura->media = $formData['media'];
            $newCandidatura->m23 = $formData['m23'];
            $newCandidatura->origem = $formData['origem'];
            $newCandidatura->obs = $formData['obs'];
            $newCandidatura->save();
            foreach ($formData['estatutos'] as $estatuto => $pretende) {
                $newCandidaturaEstatuto = new CandidaturaEstatuto();
                $newCandidaturaEstatuto->estatuto = $estatuto;
                $newCandidaturaEstatuto->candidatura_id = $newCandidatura->id;
                $newCandidaturaEstatuto->pretende = $pretende;
                $newCandidaturaEstatuto->save();
            }
            return $newCandidatura;
        });
        // $candidatura has the instance of the newly created candidatura
        $url = route('candidaturas.show', ['candidatura' => $candidatura]);
        $htmlMessage = "Candidatura <a href='$url'>#{$candidatura->id}</a> em nome de
                        <strong>\"{$candidatura->nome}\"</strong> foi criada com sucesso!";
        return redirect()->route('candidaturas.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    // /**
    //  * Display the specified resource.
    //  */
    public function show(Candidatura $candidatura): View
    {
        $cursos = Curso::all();
        return view('candidaturas.show', compact('candidatura', 'cursos'));
    }
}
