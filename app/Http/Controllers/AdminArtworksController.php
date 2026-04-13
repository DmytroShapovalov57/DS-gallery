<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminArtworkController extends Controller
{
    public function index(Request $request)
    {
        $query = Artwork::query();

        if ($search = $request->get('search')) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('artist', 'like', "%{$search}%");
        }

        $sort = $request->get('sort', 'title_asc');
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'year_asc'   => $query->orderBy('year', 'asc'),
            'year_desc'  => $query->orderBy('year', 'desc'),
            default      => $query->orderBy('title', 'asc'),
        };

        $artworks = $query->paginate(9)->withQueryString();

        return view('admin_artworks', compact('artworks'));
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
