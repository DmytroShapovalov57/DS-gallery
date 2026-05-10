<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $newArrivals = Product::latest()->take(3)->get();
        $artists = Artist::orderBy('name')->get();

        return view('home', compact('newArrivals', 'artists'));
    }
}
