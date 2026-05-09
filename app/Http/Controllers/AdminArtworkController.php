<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminArtworkController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', 'artwork');
        $query = Artwork::with('artist')->where('category', $category);

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

        if ($category === 'tool') {
            if ($request->filled('type')) {
                $query->whereIn('genre', (array) $request->type);
            }
        } else {
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

        $artworks = $query->paginate(8)->withQueryString();

        $genres = Artwork::where('category', $category)
            ->whereNotNull('genre')
            ->select('genre')
            ->distinct()
            ->orderBy('genre')
            ->pluck('genre');

        $artists = Artist::whereHas('artworks', function($q) use ($category) {
            $q->where('category', $category);
        })->orderBy('name')->pluck('name', 'artist_id');

        $minPrice = (int) Artwork::where('category', $category)->min('price');
        $maxPrice = (int) Artwork::where('category', $category)->max('price');
        $minYear  = (int) Artwork::where('category', $category)->whereNotNull('year')->min('year');
        $maxYear  = (int) Artwork::where('category', $category)->whereNotNull('year')->max('year');

        return view('admin_artworks', compact('artworks', 'genres', 'artists', 'minPrice',
            'maxPrice', 'minYear', 'maxYear', 'category'));
    }

    public function create()
    {
        $genres = Artwork::distinct()->orderBy('genre')->pluck('genre');

        return view('admin_add', compact('genres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'artist'      => 'required|string|max:255',
            'year'        => 'required|integer|min:1000|max:2100',
            'genre'       => 'required|string|max:100',
            'category'    => 'required|in:artwork,tool',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $path          = $request->file('image')->store('images/art/uploads', 'public');
            $data['image'] = 'storage/' . $path;
        } else {
            $data['image'] = 'images/art/van_gogh/Bridges_across_the_Seine_at_Asnieres.jpg';
        }

        Artwork::create($data);

        return redirect()->route('admin.artworks')
            ->with('success', 'Artwork created successfully.');
    }

    public function edit(Artwork $artwork)
    {
        $genres = Artwork::distinct()->orderBy('genre')->pluck('genre');

        return view('admin_detail', compact('artwork', 'genres'));
    }

    public function update(Request $request, Artwork $artwork)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'artist'      => 'required|string|max:255',
            'year'        => 'required|integer|min:1000|max:2100',
            'genre'       => 'required|string|max:100',
            'category'    => 'required|in:artwork,tool',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $path          = $request->file('image')->store('images/art/uploads', 'public');
            $data['image'] = 'storage/' . $path;
        } else {
            unset($data['image']);
        }

        $artwork->update($data);

        return redirect()->route('admin.artworks')
            ->with('success', 'Artwork updated successfully.');
    }

    public function destroy(Artwork $artwork)
    {
        $artwork->delete();

        return redirect()->route('admin.artworks')
            ->with('success', 'Artwork deleted.');
    }
}
