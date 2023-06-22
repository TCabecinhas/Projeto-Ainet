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
        $precos->unit_price_catalog          = $data['unit_price_catalog'];
        $precos->unit_price_own           = $data['unit_price_own'];
        $precos->unit_price_catalog_discount = $data['unit_price_catalog_discount'];
        $precos->unit_price_own_discount  = $data['unit_price_own_discount'];
        $precos->qty_discount        = $data['qty_discount'];

        $precos->save();

        return redirect()->route('dashboard.precos.edit')->with('success', 'Os preços foram atualizados com sucesso!');
    }
}
