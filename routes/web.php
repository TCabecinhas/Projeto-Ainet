<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\CandidaturaController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriaController;

Route::view('/', 'home')->name('root');

Route::resource('cursos', CursoController::class);
Route::get('cursos/{curso}/plano', [CursoController::class, 'planoCurricular'])->name('cursos.plano_curricular');

Route::get('disciplinas/minhas', [DisciplinaController::class, 'minhasDisciplinas'])->name('disciplinas.minhas');
Route::resource('disciplinas', DisciplinaController::class);

Route::resource('departamentos', DepartamentoController::class);

Route::resource('docentes', DocenteController::class);
Route::delete('docentes/{docente}/foto', [DocenteController::class, 'destroy_foto'])->name('docentes.foto.destroy');

Route::resource('alunos', AlunoController::class);
Route::delete('alunos/{aluno}/foto', [AlunoController::class, 'destroy_foto'])->name('alunos.foto.destroy');

Route::resource('candidaturas', CandidaturaController::class)->only(['index', 'show', 'create', 'store']);

Route::resource('categorias', CategoriaController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Add a "disciplina" to the cart:
Route::post('cart/{disciplina}', [CartController::class, 'addToCart'])->name('cart.add');

// Remove a "disciplina" from the cart:
Route::delete('cart/{disciplina}', [CartController::class, 'removeFromCart'])->name('cart.remove');

// Show the cart:
Route::get('cart', [CartController::class, 'show'])->name('cart.show');

// Confirm (store) the cart and save disciplinas registration on the database:
Route::post('cart', [CartController::class, 'store'])->name('cart.store');

// Clear the cart:
Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');
