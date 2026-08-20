<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->where('status', 'active')->latest()->take(8)->get();
        $categories = Category::all();
        return view('home', compact('products', 'categories'));
    }
}
