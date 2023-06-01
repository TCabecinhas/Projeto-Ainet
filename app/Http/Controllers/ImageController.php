<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\Image;

class ImageController extends Controller
{
    public function index()
    {
        $image = Image::all();
        return view('images.index', compact('image'));
    }

    public function create()
    {
        return view('images.create');
    }

    public function store(ImageRequest $request)
    {
        $image = Image::create($request->validated());
        return redirect()->route('images.show', $image->id);
    }

    public function show(Image $image)
    {
        return view('images.show', compact('image'));
    }

    public function edit(Image $image)
    {
        return view('images.edit', compact('image'));
    }

    public function update(ImageRequest $request, Image $image)
    {
        $image->update($request->validated());
        return redirect()->route('images.show', $image->id);
    }

    public function destroy(Image $image)
    {
        $image->delete();
        return redirect()->route('images.index');
    }
}
