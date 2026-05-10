<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function shipping()
    {
        if (empty(session('cart', []))) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to continue.');
        }

        $user = Auth::user();

        return view('cart_shipping', compact('user'));
    }


    public function processShipping(Request $request)
    {
        $shipping = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:30',
            'country' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:12',
            'address' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
        ],
        [   // Error messages
            'phone.regex' => 'Invalid phone number',
        ]);


        session(['shipping' => $shipping]);

        return redirect()->route('orders.payment'); // Редирект на GET маршрут
    }

    public function payment()
    {
        if (empty(session('cart')) || empty(session('shipping'))) {
            return redirect()->route('cart.shipping');
        }

        $cart = session('cart', []);
        $total = collect($cart)->sum(fn ($i) => $i['price'] * $i['quantity']);

        return view('cart_payment', compact('total'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = session('cart', []);
        $shipping = session('shipping', []);

        if (empty($cart) || empty($shipping)) {
            return redirect()->route('cart');
        }

        $request->validate([
            'payment_method' => 'required|in:card,paypal,bank',
            'card_name' => 'required|string|max:255',
            'card_number' => [
                'required',
                'regex:/^[0-9\s]{13,19}$/' // Only numbers
            ],
            'mmyy' => [
                'required',
                'regex:/^(0[1-9]|1[0-2])\/?([0-9]{2})$/' // MM/YY
            ],
            'cvv' => 'required|numeric|digits:3',

        ], [ // Error messages
            'card_number.regex' => 'Invalid card number.',
            'mmyy.regex' => 'Invalid MM/YY',
            'cvv.digits'        => 'Invalid CVV',
        ]);

        $total = collect($cart)->sum(fn ($i) => $i['price'] * $i['quantity']);

        $order = Order::create([
            ...$shipping,
            'user_id' => Auth::id(),
            'status' => 'paid',
            'total' => $total,
            'payment_method' => $request->payment_method,
        ]);

        foreach ($cart as $item) {
            $order->items()->create([
                'product_id' => $item['id'],
                'title' => $item['title'],
                'artist' => $item['artist'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        session()->forget(['cart', 'shipping']);
        CartItem::where('user_id', Auth::id())->delete();
        return redirect()->route('orders.show', $order)->with('success');
    }

    public function show(Order $order)
    {
        if (Auth::check() && $order->user_id && $order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product.images');

        return view('order_detail', compact('order'));
    }
}
