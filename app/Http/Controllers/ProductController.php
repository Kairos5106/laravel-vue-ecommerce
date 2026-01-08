<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('search');

        $products = Product::query()
            ->when($search, function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->get();

        return Inertia::render('Catalogue', [
            'products' => Product::all(),
            'filters' => $request->only(['search'])
        ]);
    }
}
