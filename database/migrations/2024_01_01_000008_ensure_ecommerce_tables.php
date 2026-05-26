<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Uzak MySQL (freesqldatabase vb.) veya yarım kalan migrate sonrası
 * sepet / bakiye tabloları eksikse oluşturur (FK yok — ücretsiz host uyumlu).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('carts')) {
            Schema::create('carts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->timestamps();
                $table->unique('user_id');
            });
        }

        if (! Schema::hasTable('cart_items')) {
            Schema::create('cart_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('cart_id');
                $table->unsignedBigInteger('product_id');
                $table->unsignedInteger('quantity');
                $table->decimal('unit_price', 10, 2);
                $table->timestamps();
                $table->unique(['cart_id', 'product_id']);
            });
        }

        if (! Schema::hasTable('user_balances')) {
            Schema::create('user_balances', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->decimal('amount', 10, 2)->default(0);
                $table->string('type');
                $table->string('description')->nullable();
                $table->unsignedBigInteger('order_id')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        //
    }
};
