<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;

class CartService
{
    public function getOrCreateCart(User $user): Cart
    {
        return Cart::firstOrCreate(['user_id' => $user->id]);
    }

    public function addItem(User $user, Product $product, int $quantity = 1): Cart
    {
        if (! $product->inStock()) {
            throw new \RuntimeException('Ürün stokta yok veya satışta değil.');
        }

        $cart = $this->getOrCreateCart($user);
        $item = $cart->items()->where('product_id', $product->id)->first();

        $newQty = ($item?->quantity ?? 0) + $quantity;
        if ($newQty > $product->stock) {
            throw new \RuntimeException('Yeterli stok yok.');
        }

        if ($item) {
            $item->update(['quantity' => $newQty]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $product->price,
            ]);
        }

        return $cart->fresh('items.product');
    }

    public function updateQuantity(CartItem $item, int $quantity): void
    {
        if ($quantity <= 0) {
            $item->delete();
            return;
        }

        if ($quantity > $item->product->stock) {
            throw new \RuntimeException('Yeterli stok yok.');
        }

        $item->update(['quantity' => $quantity]);
    }

    public function removeItem(CartItem $item): void
    {
        $item->delete();
    }

    public function clear(Cart $cart): void
    {
        $cart->items()->delete();
    }
}
