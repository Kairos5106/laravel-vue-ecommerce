<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // Default to empty array if session is empty
        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back();
    }

    public function increment($id)
    {
        // find item in session and decrease
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
        }

        return back();
    }

    public function decrement($id)
    {
        // find item in session and increase
        $cart = session()->get('cart', []);

        if ($cart[$id]['quantity'] === 1) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        if (isset($cart[$id]) && $cart[$id]['quantity'] != 0) {
            $cart[$id]['quantity']--;
            session()->put('cart', $cart);
        }

        return back();
    }

    public function clear($id)
    {
        $cart = session()->get('cart', []);

        // set item quantity to 0
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back();
    }
}
