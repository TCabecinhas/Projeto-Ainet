<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\User;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\DocenteRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $departamentos = Departamento::all();
        $filterByDepartamento = $request->departamento ?? '';
        $filterByNome = $request->nome ?? '';
        $docenteQuery = Docente::query();
        if ($filterByDepartamento !== '') {
            $docenteQuery->where('departamento', $filterByDepartamento);
        }
        if ($filterByNome !== '') {
            $userIds = User::where('name', 'like', "%$filterByNome%")->pluck('id');
            $docenteQuery->whereIntegerInRaw('user_id', $userIds);
        }
        // ATENÇÃO: Comparar estas 2 alternativas com Laravel Telescope
        //$docentes = $docenteQuery->paginate(10);
        $docentes = $docenteQuery->with('departamentoRef', 'user')->paginate(10);
        return view('docentes.index', compact('docentes', 'departamentos', 'filterByDepartamento', 'filterByNome'));
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    public function create(): View
    {
        $docente = new Docente();
        $user = new User();
        // Garante que atribute user existe (mas não grava nada na BD)
        // É necessário, para reaproveitar os forms,
        // porque o form para edit pressupoe que user existe
        $docente->user = $user;
        // Departamento default
        $docente->departamento = 'DEI';
        $departamentos = Departamento::all();
        return view('docentes.create', compact('docente', 'departamentos'));
    }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    public function store(DocenteRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        $docente = DB::transaction(function () use ($formData, $request) {
            $newUser = new User();
            $newUser->tipo = 'D';
            $newUser->name = $formData['name'];
            $newUser->email = $formData['email'];
            $newUser->admin = $formData['admin'];
            $newUser->genero = $formData['genero'];
            $newUser->password = Hash::make($formData['password_inicial']);
            $newUser->save();
            $newDocente = new Docente();
            $newDocente->user_id = $newUser->id;
            $newDocente->departamento = $formData['departamento'];
            $newDocente->gabinete = $formData['gabinete'];
            $newDocente->cacifo = $formData['cacifo'];
            $newDocente->extensao = $formData['extensao'];
            $newDocente->save();
            if ($request->hasFile('file_foto')) {
                $path = $request->file_foto->store('public/fotos');
                $newUser->url_foto = basename($path);
                $newUser->save();
            }
            return $newDocente;
        });
        $url = route('docentes.show', ['docente' => $docente]);
        $htmlMessage = "Docente <a href='$url'>#{$docente->id}</a>
                        <strong>\"{$docente->user->name}\"</strong> foi criada com sucesso!";
        return redirect()->route('docentes.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    // /**
    //  * Display the specified resource.
    //  */
    public function show(Docente $docente): View
    {
        $departamentos = Departamento::all();
        $docente->load('disciplinas', 'disciplinas.cursoRef');
        return view('docentes.show', compact('docente', 'departamentos'));
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    public function edit(Docente $docente): View
    {
        $departamentos = Departamento::all();
        return view('docentes.edit', compact('docente', 'departamentos'));
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    public function update(DocenteRequest $request, Docente $docente): RedirectResponse
    {
        $formData = $request->validated();
        $docente = DB::transaction(function () use ($formData, $docente, $request) {
            $docente->departamento = $formData['departamento'];
            $docente->gabinete = $formData['gabinete'];
            $docente->cacifo = $formData['cacifo'];
            $docente->extensao = $formData['extensao'];
            $docente->save();
            $user = $docente->user;
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
            return $docente;
        });
        $url = route('docentes.show', ['docente' => $docente]);
        $htmlMessage = "Docente <a href='$url'>#{$docente->id}</a>
                        <strong>\"{$docente->user->name}\"</strong> foi alterado com sucesso!";
        return redirect()->route('docentes.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    public function destroy(Docente $docente): RedirectResponse
    {
        try {
            $totalDisciplinas = DB::scalar('select count(*) from docentes_disciplinas where docente_id = ?', [$docente->id]);
            $user = $docente->user;
            if ($totalDisciplinas == 0) {
                DB::transaction(function () use ($docente, $user) {
                    $docente->delete();
                    $user->delete();
                });
                if ($user->url_foto) {
                    Storage::delete('public/fotos/' . $user->url_foto);
                }
                $htmlMessage = "Docente #{$docente->id}
                        <strong>\"{$user->name}\"</strong> foi apagado com sucesso!";
                return redirect()->route('docentes.index')
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', 'success');
            } else {
                $url = route('docentes.show', ['docente' => $docente]);
                $alertType = 'warning';
                $disciplinasStr = $totalDisciplinas > 0 ?
                    ($totalDisciplinas == 1 ?
                        "está a lecionar 1 disciplina" :
                        "está a lecionar $totalDisciplinas disciplinas") :
                    "";
                $htmlMessage = "Docente <a href='$url'>#{$docente->id}</a>
                    <strong>\"{$user->name}\"</strong>
                    não pode ser apagado porque $disciplinasStr!
                    ";
            }
        } catch (\Exception $error) {
            $url = route('docentes.show', ['docente' => $docente]);
            $htmlMessage = "Não foi possível apagar o docente <a href='$url'>#{$docente->id}</a>
                        <strong>\"{$user->name}\"</strong> porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }


    public function destroy_foto(Docente $docente): RedirectResponse
    {
        if ($docente->user->url_foto) {
            Storage::delete('public/fotos/' . $docente->user->url_foto);
            $docente->user->url_foto = null;
            $docente->user->save();
        }
        return redirect()->route('docentes.edit', ['docente' => $docente])
            ->with('alert-msg', 'Foto do docente "' . $docente->user->name . '" foi removida!')
            ->with('alert-type', 'success');
    }
}
