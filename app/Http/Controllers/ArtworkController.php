<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Artist;
use Illuminate\Http\Request;

class ArtworkController extends Controller
{
    public function index(Request $request)
    {
        $query = Artwork::query()->with('artist');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('artist', function ($a) use ($search) {
                        $a->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->price_max);
        }

        if ($request->filled('genre')) {
            $query->whereIn('genre', (array) $request->genre);
        }

        if ($request->filled('artist')) {
            $query->whereIn('artist_id', (array) $request->artist);
        }

        if ($request->filled('year_min')) {
            $query->where('year', '>=', (int) $request->year_min);
        }

        if ($request->filled('year_max')) {
            $query->where('year', '<=', (int) $request->year_max);
        }

        $sort = $request->get('sort', 'title_asc');

        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'year_asc' => $query->orderBy('year', 'asc'),
            'year_desc' => $query->orderBy('year', 'desc'),
            'title_desc' => $query->orderBy('title', 'desc'),
            default => $query->orderBy('title', 'asc'),
        };

        $artworks = $query->paginate(9)->withQueryString();

        $genres = Artwork::select('genre')
            ->distinct()
            ->orderBy('genre')
            ->pluck('genre');

        $artists = Artist::orderBy('name')->pluck('name', 'artist_id');

        $minPrice = (int) Artwork::min('price');
        $maxPrice = (int) Artwork::max('price');
        $minYear = (int) Artwork::min('year');
        $maxYear = (int) Artwork::max('year');

        return view('artworks', compact(
            'artworks',
            'genres',
            'artists',
            'minPrice',
            'maxPrice',
            'minYear',
            'maxYear'
        ));
    }

    public function show(Artwork $artwork)
    {
        return view('detail', compact('artwork'));
    }
}
