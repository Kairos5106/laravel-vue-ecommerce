<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('catalogue', [ProductController::class, 'index'])
->name('catalogue');

Route::get('cart', function () {
    return Inertia::render('Cart', [
        'cart' => session()->get('cart', [])
    ]);
})
->name('cart.index');

Route::post('cart', [CartController::class, 'store'])
->name('cart.store');

Route::post('/cart/increment/{id}', [CartController::class, 'increment'])
->name('cart.increment');

Route::post('/cart/decrement/{id}', [CartController::class, 'decrement'])
->name('cart.decrement');

Route::post('/cart/clear/{id}', [CartController::class, 'clear'])
->name('cart.clear');

Route::post('/checkout', [CartController::class, 'checkout'])
->name('cart.checkout');

Route::get('purchases', [PurchaseController::class, 'index'])
->name('purchases');

require __DIR__ . '/settings.php';
