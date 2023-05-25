<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Departamento;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DepartamentoRequest;

class DepartamentoController extends Controller
{
    public function index(): View
    {
        $departamentos = Departamento::all();
        return view('departamentos.index', compact('departamentos'));
    }

    public function show(Departamento $departamento): View
    {
        $departamento->load('docentes', 'docentes.user');
        return view('departamentos.show')->with('departamento', $departamento);
    }

    public function create(): View
    {
        $departamento = new Departamento();
        return view('departamentos.create')->with('departamento', $departamento);
    }

    public function store(DepartamentoRequest $request): RedirectResponse
    {
        $departamento = Departamento::create($request->validated());
        $url = route('departamentos.show', ['departamento' => $departamento]);
        $htmlMessage = "Departamento <a href='$url'>{$departamento->abreviatura}</a>
                        <strong>\"{$departamento->nome}\"</strong> foi criado com sucesso!";
        return redirect()->route('departamentos.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function edit(Departamento $departamento): View
    {
        return view('departamentos.edit')->with('departamento', $departamento);
    }

    public function update(DepartamentoRequest $request, Departamento $departamento): RedirectResponse
    {
        $departamento->update($request->validated());
        $url = route('departamentos.show', ['departamento' => $departamento]);
        $htmlMessage = "Departamento <a href='$url'>{$departamento->abreviatura}</a>
                        <strong>\"{$departamento->nome}\"</strong> foi alterado com sucesso!";
        return redirect()->route('departamentos.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function destroy(Departamento $departamento): RedirectResponse
    {
        try {
            $totalDocentes = DB::scalar('select count(*) from docentes where departamento = ?', [$departamento->abreviatura]);
            if ($totalDocentes == 0) {
                $departamento->delete();
                $htmlMessage = "Departamento {$departamento->abreviatura}
                        <strong>\"{$departamento->nome}\"</strong> foi apagado com sucesso!";
                return redirect()->route('departamentos.index')
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', 'success');
            } else {
                $url = route('departamentos.show', ['departamento' => $departamento]);
                $alertType = 'warning';
                $docenteStr = $totalDocentes == 1 ?
                    "1 docente associado ao departamento" :
                    "$totalDocentes docentes associados ao departamento";
                $htmlMessage = "Departamento <a href='$url'>{$departamento->abreviatura}</a>
                        <strong>\"{$departamento->nome}\"</strong>
                        não pode ser apagado porque há $docenteStr!";
            }
        } catch (\Exception $error) {
            $url = route('departamentos.show', ['departamento' => $departamento]);
            $htmlMessage = "Não foi possível apagar o departamento <a href='$url'>{$departamento->abreviatura}</a>
                        <strong>\"{$departamento->nome}\"</strong> porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }
}
