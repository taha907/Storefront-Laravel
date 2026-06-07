<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Yalnızca PostgreSQL veritabanında çalışır
        if (DB::connection()->getDriverName() === 'pgsql') {
            $tables = [
                'users', 'categories', 'products', 'product_images',
                'carts', 'cart_items', 'orders', 'order_items', 'user_balances'
            ];

            foreach ($tables as $table) {
                // Tablo varsa sequence'i maksimum ID'ye göre güncelle
                $hasTable = DB::select("SELECT to_regclass('public.{$table}') as exists")[0]->exists;
                if ($hasTable) {
                    try {
                        $maxId = DB::table($table)->max('id') ?? 0;
                        $nextId = $maxId + 1;
                        DB::statement("ALTER SEQUENCE {$table}_id_seq RESTART WITH {$nextId}");
                    } catch (\Exception $e) {
                        // Eğer tablo id kullanmıyorsa veya sequence adı farklıysa atla
                    }
                }
            }
        }
    }

    public function down(): void
    {
        //
    }
};
