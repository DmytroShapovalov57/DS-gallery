<?php

namespace App\Http\Controllers;

use App\Models\Artwork;

class HomeController extends Controller
{
    public function index()
    {
        $newArrivals = Artwork::latest()->take(3)->get();

        return view('home', compact('newArrivals'));
    }
}
