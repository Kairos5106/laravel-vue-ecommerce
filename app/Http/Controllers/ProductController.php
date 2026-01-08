<?php

namespace App\Http\Controllers;

class ProductController extends Controller
{
    public function index() {
        return Inertia::render('Catalogue', [
            'products' => Products::all(),
        ]);
    }
}
