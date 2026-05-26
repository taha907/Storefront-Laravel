<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\BalanceService;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private OrderService $orderService,
        private BalanceService $balanceService,
    ) {}

    public function index()
    {
        $cart = $this->cartService->getOrCreateCart(auth()->user());
        // Canlı DB'de bazen eski/yarım migrationlardan orphan cart_items kalabiliyor (product silinmiş).
        // Bu durum view'da $item->product->... erişimlerinde 500 üretir.
        $cart->items()->whereDoesntHave('product')->delete();
        $cart->load('items.product');
        $balance = $this->balanceService->getBalance(auth()->user());

        return view('shop.cart.index', compact('cart', 'balance'));
    }

    public function add(Product $product)
    {
        try {
            $this->cartService->addItem(auth()->user(), $product);
            return back()->with('success', 'Ürün sepete eklendi.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, CartItem $item)
    {
        $this->authorizeCartItem($item);

        try {
            $this->cartService->updateQuantity($item, (int) $request->quantity);
            return back()->with('success', 'Sepet güncellendi.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function remove(CartItem $item)
    {
        $this->authorizeCartItem($item);
        $this->cartService->removeItem($item);

        return back()->with('success', 'Ürün sepetten çıkarıldı.');
    }

    public function checkout()
    {
        $cart = $this->cartService->getOrCreateCart(auth()->user());
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Sepetiniz boş.');
        }

        $balance = $this->balanceService->getBalance(auth()->user());
        $user = auth()->user();

        return view('shop.cart.checkout', compact('cart', 'balance', 'user'));
    }

    public function placeOrder(Request $request)
    {
        $data = $request->validate([
            'shipping_address' => 'required|string',
            'shipping_city' => 'nullable|string',
            'shipping_phone' => 'nullable|string',
            'card_number' => 'required|string|min:16|max:19',
            'card_name' => 'required|string',
            'card_expiry' => 'required|string',
            'card_cvv' => 'required|string|min:3|max:4',
        ]);

        $cart = $this->cartService->getOrCreateCart(auth()->user());
        $cart->load('items.product');

        try {
            $order = $this->orderService->createFromCart(auth()->user(), $cart, $data);
            return redirect()->route('user.orders.show', $order)
                ->with('success', 'Siparişiniz alındı. Onay bekleniyor.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    private function authorizeCartItem(CartItem $item): void
    {
        if ($item->cart->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
