<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EncomendaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TshirtImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrecoController;
use App\Http\Controllers\TshirtController;
use App\Http\Controllers\UserController;
use App\Models\TshirtImage;
use Illuminate\Support\Facades\Route;

// Página principal
Route::get('/', [HomeController::class, 'index'])->name('index');

// Tshirt Images
Route::get('tshirtImages', [TshirtImageController::class, 'catalogo'])->name('tshirtImages.catalogo');
Route::get('tshirtImages/{id}', [TshirtImageController::class, 'tshirtImage'])->name('tshirtImages.tshirtImage');
Route::get('tshirtImages/image/{path}', [TshirtImageController::class, 'getFile'])->name('tshirtImages.get-file');
Route::get('tshirtImages/category/{id}', [TshirtImageController::class, 'category'])->name('tshirtImages.category');


// Carrinho
Route::get('/carrinho', [EncomendaController::class, 'carrinho'])->name('carrinho');
Route::post('/carrinho/adicionar-catalogo/{tshirtImage}', [TshirtController::class, 'adicionarCatalogoCarrinho'])->name('tshirts.adicionar-catalogo-carrinho');
Route::get('carrinho/eliminar/{index}', [TshirtController::class, 'eliminarTshirt'])->name('tshirts.eliminar-tshirt');
Route::get('carrinho/editar-catalogo/{index}', [TshirtController::class, 'editarTshirtCatalogo'])->name('tshirts.editar-tshirt-catalogo');
Route::put('carrinho/atualizar-catalogo/{index}', [TshirtController::class, 'atualizarTshirtCatalogo'])->name('tshirts.atualizar-tshirt-catalogo');


Route::middleware('auth')->group(function () {
    // Tshirt personalizada
    Route::get('tshirts/criar-personalizada', [TshirtController::class, 'criarPersonalizada'])->middleware('can:is-client')->name('tshirts.criar-personalizada');
    Route::get('carrinho/editar-personalizada/{index}', [TshirtController::class, 'editarPersonalizada'])->name('tshirts.editar-personalizada');
    Route::get('/carrinho/adicionar-catalogo/{tshirtImage}', [TshirtController::class, 'adicionarCatalogoCarrinho'])->name('tshirts.adicionar-catalogo-carrinho');
    Route::post('carrinho/adicionar-personalizada', [TshirtController::class, 'adicionarPersonalizadaAoCarrinho'])->name('tshirts.adicionar-personalizada-carrinho');
    Route::put('carrinho/atualizar/{index}', [TshirtController::class, 'atualizarPersonalizada'])->name('tshirts.atualizar-personalizada');

    // Carrinho
    Route::get('carrinho/checkout', [EncomendaController::class, 'checkout'])->middleware('can:is-client')->name('carrinho.checkout');
    Route::post('carrinho/encomendar', [EncomendaController::class, 'encomendar'])->middleware('can:is-client')->name('carrinho.encomendar');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Encomendas
    Route::get('/dashboard/encomendas', [EncomendaController::class, 'index'])->name('dashboard.encomendas.index');
    Route::get('/dashboard/encomendas/{encomenda}', [EncomendaController::class, 'view'])->name('dashboard.encomendas.view');
    Route::put('/dashboard/encomendas/pay/{encomenda}', [EncomendaController::class, 'pay'])->middleware('can:pay,encomenda,App\Models\Encomenda')->name('dashboard.encomendas.pay');
    Route::put('/dashboard/encomendas/close/{encomenda}', [EncomendaController::class, 'close'])->middleware('can:close,encomenda,App\Models\Encomenda')->name('dashboard.encomendas.close');
    Route::put('/dashboard/encomendas/cancel/{encomenda}', [EncomendaController::class, 'cancel'])->middleware('can:cancel,encomenda,App\Models\Encomenda')->name('dashboard.encomendas.cancel');
    Route::get('/dashboard/encomendas/recibo/{encomenda}', [EncomendaController::class, 'recibo'])->middleware('can:recibo,encomenda,App\Models\Encomenda')->name('dashboard.encomendas.recibo');

    // Perfil
    Route::get('/dashboard/profile', [UserController::class, 'profile'])->middleware('can:is-client-or-admin')->name('dashboard.profile');
    Route::put('/dashboard/profile/update/{user}', [UserController::class, 'atualizarPerfil'])->middleware('can:is-client-or-admin')->name('dashboard.users.atualizar-perfil');
    Route::delete('/dashboard/profile/foto/{user}', [UserController::class, 'apagarFoto'])->middleware('can:is-client-or-admin')->name('users.apagar-foto');

    // Imagens
    Route::get('/dashboard/tshirtImages', [TshirtImageController::class, 'index'])->name('dashboard.tshirtImages.index');
    Route::get('/dashboard/tshirtImages/create', [TshirtImageController::class, 'create'])->name('dashboard.tshirtImages.create');
    Route::post('/dashboard/tshirtImages/', [TshirtImageController::class, 'store'])->name('dashboard.tshirtImages.store');
    Route::get('/dashboard/tshirtImages/apagadas', [TshirtImageController::class, 'apagadas'])->name('dashboard.tshirtImages.apagadas');
    Route::get('/dashboard/tshirtImages/{tshirtImage}', [TshirtImageController::class, 'view'])->name('dashboard.tshirtImages.view');
    Route::get('/dashboard/tshirtImages/edit/{tshirtImage}', [TshirtImageController::class, 'edit'])->name('dashboard.tshirtImages.edit');
    Route::put('/dashboard/tshirtImages/{tshirtImage}', [TshirtImageController::class, 'update'])->name('dashboard.tshirtImages.update');
    Route::put('/dashboard/tshirtImages/restore/{tshirtImage}', [TshirtImageController::class, 'restore'])->name('dashboard.tshirtImages.restore');
    Route::delete('/dashboard/tshirtImages/{tshirtImage}', [TshirtImageController::class, 'destroy'])->name('dashboard.tshirtImages.destroy');

    // Cores
    Route::get('/dashboard/cores', [CorController::class, 'index'])->name('dashboard.cores.index');
    Route::get('/dashboard/cores/create', [CorController::class, 'create'])->name('dashboard.cores.create');
    Route::post('/dashboard/cores/', [CorController::class, 'store'])->name('dashboard.cores.store');
    Route::get('/dashboard/cores/edit/{cor}', [CorController::class, 'edit'])->name('dashboard.cores.edit');
    Route::put('/dashboard/cores/{cor}', [CorController::class, 'update'])->name('dashboard.cores.update');
    Route::delete('/dashboard/cores/{cor}', [CorController::class, 'destroy'])->name('dashboard.cores.destroy');

    // Preco
    Route::get('/dashboard/precos', [PrecoController::class, 'edit'])->middleware('can:is-admin')->name('dashboard.precos.edit');
    Route::put('/dashboard/precos/{precos}', [PrecoController::class, 'update'])->middleware('can:is-admin')->name('dashboard.precos.update');

    // Categorias
    Route::get('/dashboard/categorias', [CategoriaController::class, 'index'])->name('dashboard.categorias.index');
    Route::get('/dashboard/categorias/create', [CategoriaController::class, 'create'])->name('dashboard.categorias.create');
    Route::post('/dashboard/categorias/', [CategoriaController::class, 'store'])->name('dashboard.categorias.store');
    Route::get('/dashboard/categorias/edit/{categoria}', [CategoriaController::class, 'edit'])->name('dashboard.categorias.edit');
    Route::put('/dashboard/categorias/{categoria}', [CategoriaController::class, 'update'])->name('dashboard.categorias.update');
    Route::delete('/dashboard/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('dashboard.categorias.destroy');

    // Utilizadores
    Route::get('/dashboard/users', [UserController::class, 'index'])->name('dashboard.users.index');
    Route::post('/dashboard/users', [UserController::class, 'store'])->name('dashboard.users.store');
    Route::get('/dashboard/users/create', [UserController::class, 'create'])->name('dashboard.users.create');
    Route::get('/dashboard/users/apagados', [UserController::class, 'apagados'])->name('dashboard.users.apagados');
    Route::get('/dashboard/users/edit/{user}', [UserController::class, 'edit'])->name('dashboard.users.edit');
    Route::get('/dashboard/users/{user}', [UserController::class, 'view'])->name('dashboard.users.view');
    Route::put('/dashboard/users/{user}', [UserController::class, 'update'])->name('dashboard.users.update');
    Route::put('/dashboard/users/restore/{user}', [UserController::class, 'restore'])->name('dashboard.users.restore');
    Route::put('/dashboard/users/block/{user}', [UserController::class, 'block'])->name('dashboard.users.block');
    Route::put('/dashboard/users/unblock/{user}', [UserController::class, 'unblock'])->name('dashboard.users.unblock');
    Route::delete('/dashboard/users/{user}', [UserController::class, 'destroy'])->name('dashboard.users.destroy');

});

// Routes de autenticação
Auth::routes(['verify' => true]);
