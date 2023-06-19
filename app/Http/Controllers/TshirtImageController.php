<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tshirt_Images\Tshirt_ImageStoreRequest;
use App\Http\Requests\Tshirt_Images\Tshirt_ImageUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\TshirtImage;
use App\Models\Cor;
use App\Models\Preco;
use Illuminate\Support\Facades\Storage;

class TshirtImageController extends Controller
{
    public function index()
    {
        $tshirtImages = TshirtImage::where('customer_id', NULL)->orderBy('created_at', 'DESC')->paginate(20);
        
        return view('dashboard.tshirtImages.index', ['tshirtImages' => $tshirtImages]);
    }

    public function create()
    {
        $categories = Category::all();

        return view('dashboard.tshirtImages.create', ['categories' => $categories]);
    }

    public function store(TshirtImageStoreRequest $request)
    {
        $data = $request->validated();

        // Upload the new image
        if ($request->hasFile('file')) {
            if ($request->file('file')->isValid()) {
                // Format the filename
                $extension = $request->file('file')->extension();
                $filename = date("Ymd_His") . "." . $extension;

                // Upload the image
                Storage::putFileAs('public/tshirtImages', $request->file('file'), $filename);

                $data['image_url'] = $filename;
                $tshirtImage = new TshirtImage();
                $tshirtImage->fill($data);

                $tshirtImage->save();

                return redirect()->route('dashboard.tshirtImages.index')->with('success', 'T-Shirt image created successfully!');
            }
        } else {
            return redirect()->route('dashboard.tshirtImages.create')->with('error', 'Failed to upload the image');
        }
    }

    public function view(TshirtImage $tshirtImage)
    {
        return view('dashboard.tshirtImages.view', ['tshirtImage' => $tshirtImage]);
    }

    public function edit(TshirtImage $tshirtImage)
    {
        $categories = Category::all();

        return view('dashboard.tshirtImages.edit', ['tshirtImage' => $tshirtImage, 'categories' => $categories]);
    }

    public function update(TshirtImage $tshirtImage, TshirtImageUpdateRequest $request)
    {
        $data = $request->validated();

        // Upload the new image
        if ($request->hasFile('file')) {
            if ($request->file('file')->isValid()) {
                // Format the filename
                $extension = $request->file('file')->extension();
                $filename = date("Ymd_His") . "." . $extension;

                // T-Shirt image is private
                if ($tshirtImage->customer_id) {
                    // Upload the image
                    Storage::putFileAs('tshirtImages_private', $request->file('file'), $filename);
                    // Delete the old image
                    Storage::delete('tshirtImages_private/' . $tshirtImage->image_url);
                } else {
                    Storage::putFileAs('public/tshirtImages', $request->file('file'), $filename);
                    Storage::delete('public/tshirtImages/' . $tshirtImage->image_url);
                }

                $tshirtImage->image_url = $filename;
            }
        }

        $tshirtImage->fill($data);

        $tshirtImage->save();

        return redirect()->route('dashboard.tshirtImages.view', $tshirtImage)->with('success', 'The t-shirt image has been successfully updated!');
    }

    public function deleted()
    {
        $tshirtImages = TshirtImage::withTrashed()->where('customer_id', NULL)->orderBy('deleted_at', 'DESC')->paginate(20);

        return view('dashboard.tshirtImages.deleted', ['tshirtImages' => $tshirtImages]);
    }

    public function restore($id)
    {
        TshirtImage::onlyTrashed()->where('id', $id)->restore();

        return redirect()->route('dashboard.tshirtImages.index')->with('success', 'The t-shirt image has been successfully restored');
    }

    public function destroy(TshirtImage $tshirtImage)
    {
        $tshirtImage->delete();

        return redirect()->route('dashboard.tshirtImages.index')->with('success', 'The t-shirt image has been deleted!');
    }

    public function catalogo()
    {
        $categories = Category::all();
        $tshirtImages = TshirtImage::where('customer_id', NULL)->paginate(15);
        return view('tshirtImages.catalogo')->with(['tshirtImages' => $tshirtImages, 'categories' => $categories]);
    }

    public function category($id)
    {
        $categories = Category::all();
        $tshirtImages = TshirtImage::where(['customer_id' => NULL, 'category_id' => $id])->paginate(15);
        return view('tshirtImages.catalogo')->with(['tshirtImages' => $tshirtImages, 'categories' => $categories]);
    }

    public function tshirtImage($id)
    {
        $prices = Price::take(1)->first();
        $tshirtImage = TshirtImage::findOrFail($id);
        $colors = Color::all();
        $recommended = TshirtImage::where('id', '<>', $id)
                    ->where('customer_id', NULL)
                    ->where('category_id', $tshirtImage->category_id)
                    ->inRandomOrder()
                    ->take(4)
                    ->get();

        return view('tshirtImages.tshirtImage')->with(['colors' => $colors, 'tshirtImage' => $tshirtImage, 'recommended' => $recommended, 'prices' => $prices]);
    }

    public function getFile($path)
    {
        return response()->file(storage_path('app/tshirtImages_private/' . $path));
    }
}
