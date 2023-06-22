<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Encomenda;
use App\Models\TshirtImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userType = $user-> user_type;

        switch($userType){
            case 'C':
                $tshirtImages = TshirtImage::where('customer_id', $user->id)->count();
                $encomendas = Encomenda::where('customer_id', $user->id)->count();
                $encomendas_finalizadas = Encomenda::where('customer_id', $user->id)->where('status', 'closed')->count();
                $encomendas_em_espera = Encomenda::where('customer_id', $user->id)->where('status', 'paid')->count();
                $encomendas_por_pagar = Encomenda::where('customer_id', $user->id)->where('status', 'pending')->count();


                return view('dashboard.cliente-index', [                   
                    'tshirtImages' => $tshirtImages,
                    'encomendas' => $encomendas,
                    'encomendas_finalizadas' => $encomendas_finalizadas,
                    'encomendas_em_espera' => $encomendas_em_espera,
                    'encomendas_por_pagar' => $encomendas_por_pagar,
                ]);
                break;

            case 'A':

                $utilizadores = User::count();
                $catalogo = TshirtImage::where('customer_id', NULL)->count();
                $cliente = User::where('user_type', 'C')->count();
                $funcionarios = User::where('user_type', 'E')->count();
                $admins = User::where('user_type', 'A')->count();
                $encomendas = Encomenda::count();
                $encomendasTotal = Encomenda::all();
                $encomendas_acao = Encomenda::where('status', 'pending')
                    ->orWhere('status', 'paid')->count();
                $categorias = Category::count();



                return view('dashboard.admin-index', [
                    'encomendasTotal' => $encomendasTotal,
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

            case 'E':
                $catalogo = TshirtImage::where('customer_id', NULL)->count();
                $cliente = User::where('user_type', 'C')->count();
                $encomendas = Encomenda::count();
                $encomendas_acao = Encomenda::where('status', 'pending')
                    ->orWhere('status', 'paid')->count();



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
