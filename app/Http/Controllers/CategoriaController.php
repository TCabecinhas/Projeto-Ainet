<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categorias\CategoriaStoreRequest;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriaController extends Controller
{
    public function index(){
        $categorias = Category::paginate(20);

        return view('dashboard.categorias.index', ['categorias' => $categorias]);
    }

    public function create(){
        return view('dashboard.categorias.create');
    }

    public function store(CategoriaStoreRequest $request){
        $data = $request->validated();

        $categoria = new Category();
        $categoria->nome = $data['nome'];
        $categoria->save();

        return redirect()->route('dashboard.categorias.index')->with('success', 'Categoria criada com sucesso');
    }

    public function edit(Category $categoria){
        return view('dashboard.categorias.edit', ['categoria' => $categoria]);
    }

    public function update(Category $categoria, CategoriaStoreRequest $request){
        $data = $request->validated();

        $categoria->nome = $data['nome'];
        $categoria->save();

        return redirect()->route('dashboard.categorias.index')->with('success', 'Categoria criada com sucesso');
    }

    public function destroy(Category $categoria){
        $categoria->delete();

        return redirect()->route('dashboard.categorias.index')->with('success', 'Categoria eliminada com sucesso');
    }
}
