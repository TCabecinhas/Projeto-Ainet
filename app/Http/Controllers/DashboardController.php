<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Cliente;
use App\Models\Encomenda;
use App\Models\TshirtImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        switch(Auth::user()->tipo){
            case 'C':
                $tshirtImages = TshirtImage::where('cliente_id', Auth::user()->id)->count();
                $encomendas = Encomenda::where('cliente_id', Auth::user()->id)->count();
                $encomendas_finalizadas = Encomenda::where('cliente_id', Auth::user()->id)->where('estado', 'fechada')->count();
                $encomendas_em_espera = Encomenda::where('cliente_id', Auth::user()->id)->where('estado', 'paga')->count();
                $encomendas_por_pagar = Encomenda::where('cliente_id', Auth::user()->id)->where('estado', 'pendente')->count();


                return view('dashboard.cliente-index', [
                    'encomendas' => $encomendas,
                    'images' => $tshirtImages,
                    'encomendas_finalizadas' => $encomendas_finalizadas,
                    'encomendas_em_espera' => $encomendas_em_espera,
                    'encomendas_por_pagar' => $encomendas_por_pagar,
                ]);
                break;

            case 'A':
                $utilizadores = User::count();
                $catalogo = TshirtImage::where('cliente_id', NULL)->count();
                $cliente = User::where('tipo', 'C')->count();
                $funcionarios = User::where('tipo', 'F')->count();
                $admins = User::where('tipo', 'A')->count();
                $encomendas = Encomenda::count();
                $encomendas_acao = Encomenda::where('estado', 'pendente')
                    ->orWhere('estado', 'paga')->count();
                $categorias = Category::count();



                return view('dashboard.admin-index', [
                    'utilizadores' => $utilizadores,
                    'catalogo' => $catalogo,
                    'cliente' => $cliente,
                    'funcionarios' => $funcionarios,
                    'admins' => $admins,
                    'encomendas' => $encomendas,
                    'encomendas_acao' => $encomendas_acao,
                    'categorias' => $categorias
                ]);
                break;

            case 'F':
                $catalogo = TshirtImage::where('cliente_id', NULL)->count();
                $cliente = User::where('tipo', 'C')->count();
                $encomendas = Encomenda::count();
                $encomendas_acao = Encomenda::where('estado', 'pendente')
                    ->orWhere('estado', 'paga')->count();



                return view('dashboard.funcionario-index', [
                    'catalogo' => $catalogo,
                    'cliente' => $cliente,
                    'encomendas' => $encomendas,
                    'encomendas_acao' => $encomendas_acao,
                ]);
                break;
        }
    }
}
