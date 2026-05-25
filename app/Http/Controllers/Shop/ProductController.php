<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::published()->with(['category', 'images']);

        if ($search = request('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categoryId = request('category')) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('shop.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        if (! $product->is_published) {
            abort(404);
        }

        $product->load(['category', 'images']);

        $related = Product::published()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('shop.products.show', compact('product', 'related'));
    }
}
