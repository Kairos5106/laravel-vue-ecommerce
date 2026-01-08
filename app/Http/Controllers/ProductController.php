<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) {
        return Inertia::render('Catalogue', [
            'products' => Product::all(),
            'filters' => $request->only(['search'])
        ]);
    }
}
