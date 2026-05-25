<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Services\ProductImageService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin OneTap',
            'email' => 'admin@onetapbilgisayar.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '02621234567',
            'is_active' => true,
        ]);

        $users = [
            ['name' => 'Ahmet Yılmaz', 'email' => 'ahmet@test.com'],
            ['name' => 'Ayşe Demir', 'email' => 'ayse@test.com'],
            ['name' => 'Mehmet Kaya', 'email' => 'mehmet@test.com'],
            ['name' => 'Zeynep Çelik', 'email' => 'zeynep@test.com'],
            ['name' => 'Can Öztürk', 'email' => 'can@test.com'],
        ];

        foreach ($users as $u) {
            User::create([
                'name' => $u['name'],
                'email' => $u['email'],
                'password' => Hash::make('user123'),
                'role' => 'user',
                'phone' => '05'.rand(100000000, 999999999),
                'address' => 'Kocaeli Merkez Mah. No:'.rand(1, 100),
                'city' => 'Kocaeli',
                'is_active' => true,
            ]);
        }

        $categories = [
            ['name' => 'İşlemci', 'slug' => 'islemci', 'description' => 'Intel ve AMD işlemciler'],
            ['name' => 'Ekran Kartı', 'slug' => 'ekran-karti', 'description' => 'NVIDIA ve AMD GPU'],
            ['name' => 'RAM', 'slug' => 'ram', 'description' => 'DDR4 ve DDR5 bellek'],
            ['name' => 'Depolama', 'slug' => 'depolama', 'description' => 'SSD ve HDD'],
            ['name' => 'Monitör', 'slug' => 'monitor', 'description' => 'Gaming ve ofis monitörleri'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        $products = [
            ['cat' => 1, 'name' => 'Intel Core i7-13700K', 'brand' => 'Intel', 'price' => 12500, 'stock' => 15],
            ['cat' => 1, 'name' => 'AMD Ryzen 7 7800X3D', 'brand' => 'AMD', 'price' => 14200, 'stock' => 12],
            ['cat' => 1, 'name' => 'Intel Core i5-13400F', 'brand' => 'Intel', 'price' => 6800, 'stock' => 25],
            ['cat' => 1, 'name' => 'AMD Ryzen 5 5600X', 'brand' => 'AMD', 'price' => 5200, 'stock' => 20],
            ['cat' => 2, 'name' => 'NVIDIA RTX 4070 Super', 'brand' => 'NVIDIA', 'price' => 28500, 'stock' => 8],
            ['cat' => 2, 'name' => 'NVIDIA RTX 4060 Ti', 'brand' => 'NVIDIA', 'price' => 18500, 'stock' => 14],
            ['cat' => 2, 'name' => 'AMD Radeon RX 7800 XT', 'brand' => 'AMD', 'price' => 22000, 'stock' => 10],
            ['cat' => 2, 'name' => 'NVIDIA RTX 4080 Super', 'brand' => 'NVIDIA', 'price' => 52000, 'stock' => 5],
            ['cat' => 3, 'name' => 'Kingston Fury 32GB DDR5 6000MHz', 'brand' => 'Kingston', 'price' => 4200, 'stock' => 30],
            ['cat' => 3, 'name' => 'Corsair Vengeance 16GB DDR4 3200MHz', 'brand' => 'Corsair', 'price' => 1850, 'stock' => 40],
            ['cat' => 3, 'name' => 'G.Skill Trident Z 64GB DDR5', 'brand' => 'G.Skill', 'price' => 8900, 'stock' => 12],
            ['cat' => 3, 'name' => 'Crucial 8GB DDR4 2666MHz', 'brand' => 'Crucial', 'price' => 950, 'stock' => 50],
            ['cat' => 4, 'name' => 'Samsung 990 Pro 1TB NVMe', 'brand' => 'Samsung', 'price' => 4800, 'stock' => 22],
            ['cat' => 4, 'name' => 'WD Black SN850X 2TB', 'brand' => 'Western Digital', 'price' => 7200, 'stock' => 18],
            ['cat' => 4, 'name' => 'Crucial P3 Plus 500GB', 'brand' => 'Crucial', 'price' => 1650, 'stock' => 35],
            ['cat' => 4, 'name' => 'Seagate BarraCuda 2TB HDD', 'brand' => 'Seagate', 'price' => 2100, 'stock' => 28],
            ['cat' => 5, 'name' => 'ASUS ROG Swift 27" 165Hz', 'brand' => 'ASUS', 'price' => 12500, 'stock' => 10],
            ['cat' => 5, 'name' => 'LG UltraGear 32" 144Hz', 'brand' => 'LG', 'price' => 9800, 'stock' => 14],
            ['cat' => 5, 'name' => 'Samsung Odyssey G5 27"', 'brand' => 'Samsung', 'price' => 6500, 'stock' => 16],
            ['cat' => 5, 'name' => 'Dell S2721DGF 27" QHD', 'brand' => 'Dell', 'price' => 8200, 'stock' => 11],
            ['cat' => 1, 'name' => 'Intel Core i9-14900K', 'brand' => 'Intel', 'price' => 19800, 'stock' => 7],
            ['cat' => 2, 'name' => 'NVIDIA RTX 4090', 'brand' => 'NVIDIA', 'price' => 78000, 'stock' => 3],
        ];

        foreach ($products as $p) {
            $slug = Str::slug($p['name']).'-'.Str::random(4);
            Product::create([
                'category_id' => $p['cat'],
                'name' => $p['name'],
                'slug' => $slug,
                'description' => $p['name'].' — '.$p['brand'].' marka orijinal ürün. OneTap Bilgisayar güvencesiyle.',
                'price' => $p['price'],
                'stock' => $p['stock'],
                'is_published' => true,
                'brand' => $p['brand'],
            ]);
        }

        $this->command?->info('Ürün görselleri indiriliyor (internet)...');
        app(ProductImageService::class)->downloadAll();
    }
}
