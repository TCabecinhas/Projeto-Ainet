<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prices = Price::all();
        return view('prices.index', compact('prices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('prices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Price::create($request->validated());

        return redirect()->route('prices.index')
            ->with('success', 'Preço criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Price $price)
    {
        return view('prices.show', compact('price'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Price $price)
    {
        return view('prices.edit', compact('price'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Price $price)
    {
        $price->update($request->validated());

        return redirect()->route('prices.index')
            ->with('success', 'Price atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Price $price)
    {
        $price->delete();

        return redirect()->route('prices.index')
            ->with('success', 'Price excluída com sucesso.');
    }
}
