<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Disciplina;
use Illuminate\Support\Facades\DB;


class CartController extends Controller
{
    public function show(): View
    {
        $cart = session('cart', []);
        return view('cart.show', compact('cart'));
    }

    public function addToCart(Request $request, Disciplina $disciplina): RedirectResponse
    {
        try {
            $userType = $request->user()->tipo ?? 'O';
            if ($userType != 'A') {
                $alertType = 'warning';
                $htmlMessage = "O utilizador não é aluno, logo não pode adicionar disciplina ao carrinho";
            } else {
                $alunoId = $request->user()->aluno->id;
                $totalDisciplina = DB::scalar('select count(*) from alunos_disciplinas where aluno_id = ? and disciplina_id = ?', [$alunoId, $disciplina->id]);
                if ($totalDisciplina >= 1) {
                    $alertType = 'warning';
                    $url = route('disciplinas.show', ['disciplina' => $disciplina]);
                    $htmlMessage = "Não é possível adicionar a disciplina <a href='$url'>#{$disciplina->id}</a>
                        <strong>\"{$disciplina->nome}\"</strong> ao carrinho, porque o aluno já está inscrito à mesma!";
                } else {
                    // We can access session with a "global" function
                    $cart = session('cart', []);
                    if (array_key_exists($disciplina->id, $cart)) {
                        $alertType = 'warning';
                        $url = route('disciplinas.show', ['disciplina' => $disciplina]);
                        $htmlMessage = "Disciplina <a href='$url'>#{$disciplina->id}</a>
                        <strong>\"{$disciplina->nome}\"</strong> não foi adicionada ao carrinho porque já está presente no mesmo!";
                    } else {
                        $cart[$disciplina->id] = $disciplina;
                        // We can access session with a request function
                        $request->session()->put('cart', $cart);
                        $alertType = 'success';
                        $url = route('disciplinas.show', ['disciplina' => $disciplina]);
                        $htmlMessage = "Disciplina <a href='$url'>#{$disciplina->id}</a>
                        <strong>\"{$disciplina->nome}\"</strong> foi adicionada ao carrinho!";
                    }
                }
            }
        } catch (\Exception $error) {
            $url = route('disciplinas.show', ['disciplina' => $disciplina]);
            $htmlMessage = "Não é possível adicionar a disciplina <a href='$url'>#{$disciplina->id}</a>
                        <strong>\"{$disciplina->nome}\"</strong> ao carrinho, porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function removeFromCart(Request $request, Disciplina $disciplina): RedirectResponse
    {
        $cart = session('cart', []);
        if (array_key_exists($disciplina->id, $cart)) {
            unset($cart[$disciplina->id]);
        }
        $request->session()->put('cart', $cart);
        $url = route('disciplinas.show', ['disciplina' => $disciplina]);
        $htmlMessage = "Disciplina <a href='$url'>#{$disciplina->id}</a>
                        <strong>\"{$disciplina->nome}\"</strong> foi removida do carrinho!";
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $userType = $request->user()->tipo ?? 'O';
            if ($userType != 'A') {
                $alertType = 'warning';
                $htmlMessage = "O utilizador não é aluno, logo não pode confirmar as inscrições às disciplina do carrinho";
            } else {
                $cart = session('cart', []);
                $total = count($cart);
                if ($total < 1) {
                    $alertType = 'warning';
                    $htmlMessage = "Não é possível confirmar as inscrições porque não há disciplina no carrinho";
                } else {
                    $aluno = $request->user()->aluno;
                    DB::transaction(function () use ($aluno, $cart) {
                        foreach ($cart as $disciplina) {
                            $aluno->disciplinas()->attach($disciplina->id, ['repetente' => 0]);
                        }
                    });
                    if ($total == 1) {
                        $htmlMessage = "Foi confirmada a inscrição a 1 disciplina ao aluno #{$aluno->id} <strong>\"{$request->user()->name}\"</strong>";
                    } else {
                        $htmlMessage = "Foi confirmada a inscrição a $total disciplinas ao aluno #{$aluno->id} <strong>\"{$request->user()->name}\"</strong>";
                    }
                    $request->session()->forget('cart');
                    return redirect()->route('disciplinas.minhas')
                        ->with('alert-msg', $htmlMessage)
                        ->with('alert-type', 'success');
                }
            }
        } catch (\Exception $error) {
            $htmlMessage = "Não foi possível confirmar a inscrição das disciplinas do carrinho, porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');
        $htmlMessage = "Carrinho está limpo!";
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }
}
