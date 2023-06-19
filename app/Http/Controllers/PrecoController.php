<?php

namespace App\Http\Controllers;

use App\Http\Requests\Precos\PrecoUpdateRequest;
use App\Models\Preco;
use Illuminate\Http\Request;

class PrecoController extends Controller
{
    public function edit(){
        $precos = Preco::take(1)->first();

        return view('dashboard.precos.edit', ['precos' => $precos]);
    }

    public function update(Preco $precos, PrecoUpdateRequest $request){
        $data = $request->validated();
        $precos->preco_un_catalogo          = $data['preco_un_catalogo'];
        $precos->preco_un_proprio           = $data['preco_un_proprio'];
        $precos->preco_un_catalogo_desconto = $data['preco_un_catalogo_desconto'];
        $precos->preco_un_proprio_desconto  = $data['preco_un_proprio_desconto'];
        $precos->quantidade_desconto        = $data['quantidade_desconto'];

        $precos->save();

        return redirect()->route('dashboard.precos.edit')->with('success', 'Os preços foram atualizados com sucesso!');
    }
}
