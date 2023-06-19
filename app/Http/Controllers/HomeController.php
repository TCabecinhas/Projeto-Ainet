<?php

namespace App\Http\Controllers;

use App\Models\TshirtImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $tshirtimages = TshirtImage::where('customer_id', NULL)
        ->inRandomOrder()
        ->take(4)
        ->get();
        return view('index')->with(['tshirtImages' => $tshirtimages]);
    }
}
