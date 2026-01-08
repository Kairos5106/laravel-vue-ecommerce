<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('catalogue', [ProductController::class, 'index'])
->name('catalogue');

Route::get('purchases', function () {
    return Inertia::render('Purchases');
})
->name('purchases');

Route::get('cart', function () {
    return Inertia::render('Cart');
})
->name('cart');

Route::post('cart', [CartController::class, 'store'])
->name('cart.store');

require __DIR__ . '/settings.php';
