<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cores\CorStoreRequest;
use App\Models\Cor;
use Illuminate\Http\Request;

class CorController extends Controller
{
    public function index(){
        $cores = Cor::paginate(20);

        return view('dashboard.cores.index', ['cores' => $cores]);
    }

    public function edit(Cor $cor){
        return view('dashboard.cores.edit', ['cor' => $cor]);
    }

    public function update(Cor $cor, CorStoreRequest $request){
        $data = $request->validated();
        $cor->fill($data);
        $cor->save();

        return redirect()->route('dashboard.cores.index')->with('success', 'A cor foi atualizada com sucesso');
    }

    public function create(){
        return view('dashboard.cores.create');
    }

    public function store(CorStoreRequest $request){
        $data = $request->validated();

        $cor = new Cor();
        $cor->code = $data['codigo'];
        $cor->name = $data['nome'];
        $cor->save();

        return redirect()->route('dashboard.cores.index')->with('success', 'A cor foi criada com sucesso');
    }


    public function destroy(Cor $cor){
        $cor->delete();
        return redirect()->route('dashboard.cores.index')->with('success', 'A cor foi eliminada com sucesso');
    }
}
