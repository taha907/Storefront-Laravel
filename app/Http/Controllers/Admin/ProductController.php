<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'images')->latest()->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);
        $data['slug'] = Str::slug($data['name']).'-'.Str::random(4);
        $data['is_published'] = $request->boolean('is_published');

        $product = Product::create($data);

        $this->handleImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Ürün eklendi.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('images');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request);
        $data['is_published'] = $request->boolean('is_published');
        $product->update($data);

        $this->handleImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Ürün güncellendi.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        $product->delete();

        return back()->with('success', 'Ürün silindi.');
    }

    public function togglePublish(Product $product)
    {
        $product->update(['is_published' => ! $product->is_published]);

        return back()->with('success', $product->is_published ? 'Ürün satışa sunuldu.' : 'Ürün satıştan kaldırıldı.');
    }

    public function deleteImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Görsel silindi.');
    }

    private function validateProduct(Request $request): array
    {
        return $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'brand' => 'nullable|string|max:100',
            'is_published' => 'boolean',
        ]);
    }

    private function handleImages(Request $request, Product $product): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        foreach ($request->file('images') as $index => $file) {
            $path = $file->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'path' => $path,
                'is_primary' => $product->images()->count() === 0 && $index === 0,
                'sort_order' => $index,
            ]);
        }
    }
}
