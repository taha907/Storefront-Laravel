<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductImageService
{
    private array $categoryKeywords = [
        1 => 'computer,cpu',
        2 => 'graphicscard,gpu',
        3 => 'ram,memory',
        4 => 'ssd,storage',
        5 => 'monitor,display',
    ];

    public function downloadAll(): int
    {
        $count = 0;

        Product::with('images', 'category')->chunkById(10, function ($products) use (&$count) {
            foreach ($products as $product) {
                if ($this->downloadForProduct($product)) {
                    $count++;
                }
            }
        });

        return $count;
    }

    public function downloadForProduct(Product $product): bool
    {
        $keyword = $this->categoryKeywords[$product->category_id] ?? 'computer,technology';
        $url = "https://loremflickr.com/600/400/{$keyword}?lock={$product->id}";

        try {
            $response = Http::timeout(45)
                ->withHeaders(['User-Agent' => 'OneTapBilgisayar/1.0'])
                ->get($url);

            if (! $response->successful()) {
                $response = Http::timeout(30)->get("https://picsum.photos/seed/onetap-{$product->id}/600/400");
            }

            if (! $response->successful()) {
                return false;
            }

            $extension = $this->guessExtension($response->header('Content-Type'));
            $filename = 'products/'.$product->slug.'.'.$extension;

            Storage::disk('public')->put($filename, $response->body());

            foreach ($product->images as $old) {
                if ($old->path !== $filename && Storage::disk('public')->exists($old->path)) {
                    Storage::disk('public')->delete($old->path);
                }
                $old->delete();
            }

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $filename,
                'is_primary' => true,
                'sort_order' => 0,
            ]);

            return true;
        } catch (\Throwable $e) {
            report($e);

            return false;
        }
    }

    private function guessExtension(?string $contentType): string
    {
        return match (true) {
            str_contains((string) $contentType, 'png') => 'png',
            str_contains((string) $contentType, 'webp') => 'webp',
            default => 'jpg',
        };
    }
}
