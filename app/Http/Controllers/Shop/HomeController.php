<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
class HomeController extends Controller
{
    public function index()
    {
        $products = Product::published()
            ->with(['category', 'images'])
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::withCount('products')->get();

        return view('shop.home', compact('products', 'categories'));
    }
}
