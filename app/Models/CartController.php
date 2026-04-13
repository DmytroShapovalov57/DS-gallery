<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        $cart = array_filter($cart, function ($item) {
            return !empty($item['id']);
        });

        $total = collect($cart)->sum(function ($item) {
            return ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
        });

        return view('cart', compact('cart', 'total'));
    }

    public function add(Request $request, Artwork $artwork)
    {
        $qty = max(1, (int) $request->input('quantity', 1));
        $cart = session('cart', []);

        $id = $artwork->artwork_id;

        $cart[$id] = [
            'id' => $id,
            'title' => $artwork->title,
            'artist' => $artwork->artist?->name ?? $artwork->artist,
            'price' => (float) $artwork->price,
            'image' => $artwork->image,
            'quantity' => ($cart[$id]['quantity'] ?? 0) + $qty,
        ];

        session(['cart' => $cart]);

        return back()->with('success', "\"{$artwork->title}\" added to cart.");
    }

    public function update(Request $request, int $id)
    {
        $cart = session('cart', []);
        $qty = max(1, (int) $request->input('quantity', 1));

        if (!isset($cart[$id])) {
            return back();
        }

        $cart[$id]['quantity'] = $qty;

        session(['cart' => $cart]);

        return back();
    }

    public function remove(int $id)
    {
        $cart = session('cart', []);

        unset($cart[$id]);

        session(['cart' => $cart]);

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        session()->forget('cart');

        return back()->with('success', 'Cart cleared.');
    }
}
