<?php

namespace App\Console\Commands;

use App\Services\ProductImageService;
use Illuminate\Console\Command;

class DownloadProductImages extends Command
{
    protected $signature = 'products:download-images';

    protected $description = 'Ürün görsellerini internetten indirip storage ve veritabanına kaydeder';

    public function handle(ProductImageService $service): int
    {
        $this->info('Görseller indiriliyor...');

        $count = $service->downloadAll();

        $this->info("{$count} ürün görseli güncellendi.");

        return self::SUCCESS;
    }
}
