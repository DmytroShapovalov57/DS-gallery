<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;

class SavedController extends Controller
{
    public function index()
    {
        $ids    = session('saved', []);
        $saved  = $ids ? Artwork::whereIn('id', $ids)->get() : collect();

        return view('saved', compact('saved'));
    }

    public function toggle(Artwork $artwork)
    {
        $saved = session('saved', []);

        if (in_array($artwork->id, $saved)) {
            $saved = array_values(array_filter($saved, fn ($id) => $id !== $artwork->id));
            $msg   = "\"{$artwork->title}\" removed from saved.";
        } else {
            $saved[] = $artwork->id;
            $msg     = "\"{$artwork->title}\" saved.";
        }
        session(['saved' => $saved]);

        return back()->with('success', $msg);
    }
}
