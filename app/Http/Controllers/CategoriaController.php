<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categorias\CategoriaStoreRequest;
use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index(){
        $categorias = Categoria::paginate(20);

        return view('dashboard.categorias.index', ['categorias' => $categorias]);
    }

    public function create(){
        return view('dashboard.categorias.create');
    }

    public function store(CategoriaStoreRequest $request){
        $data = $request->validated();

        $categoria = new Categoria();
        $categoria->nome = $data['nome'];
        $categoria->save();

        return redirect()->route('dashboard.categorias.index')->with('success', 'Categoria criada com sucesso');
    }

    public function edit(Categoria $categoria){
        return view('dashboard.categorias.edit', ['categoria' => $categoria]);
    }

    public function update(Categoria $categoria, CategoriaStoreRequest $request){
        $data = $request->validated();

        $categoria->nome = $data['nome'];
        $categoria->save();

        return redirect()->route('dashboard.categorias.index')->with('success', 'Categoria criada com sucesso');
    }

    public function destroy(Categoria $categoria){
        $categoria->delete();

        return redirect()->route('dashboard.categorias.index')->with('success', 'Categoria eliminada com sucesso');
    }
}
