<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return Inertia::render('Purchases', [
            'orders' => $orders
        ]);
    }

    public function markAsReceived($id): RedirectResponse
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $order->update([
            'status' => 'completed'
        ]);

        return back()->with('success', 'Order marked as completed!');
    }
}
