<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('status', 'active');

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('shop', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'galleries'])->where('slug', $slug)->firstOrFail();
        $categories = Category::all();

        // Ambil produk terkait (related products)
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        // Untuk best sellers di sidebar
        $bestSellers = Product::where('is_featured', true)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('product-detail', compact(
            'product',
            'categories',
            'relatedProducts',
            'bestSellers'
        ));
    }
}
