<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // Default to empty array if session is empty
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
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

    public function checkout()
    {
        $cart = session()->get('cart', []);

        try {
            // 1. Create the Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']),
                'status' => 'pending',
            ]);

            if (!$order->id) {
                throw new \Exception("Order created but ID is NULL");
            }

            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            session()->forget('cart');
            return redirect()->route('catalogue');

        } catch (\Exception $e) {
            // This will print the error and the EXACT state of the $order variable
            dd([
                'Error' => $e->getMessage(),
                'Order_ID' => $order->id ?? 'STILL NULL',
                'Current_Cart' => $cart
            ]);
        }
    }
}
