<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(
        private CartService $cartService,
        private BalanceService $balanceService,
    ) {}

    public function createFromCart(User $user, Cart $cart, array $data): Order
    {
        if ($cart->items->isEmpty()) {
            throw new \RuntimeException('Sepetiniz boş.');
        }

        return DB::transaction(function () use ($user, $cart, $data) {
            $subtotal = $cart->total;
            $balance = $this->balanceService->getBalance($user);
            $balanceUsed = min($balance, $subtotal);
            $cardPaid = $subtotal - $balanceUsed;

            $order = Order::create([
                'order_number' => 'OTP-'.strtoupper(Str::random(8)),
                'user_id' => $user->id,
                'status' => OrderStatus::Pending->value,
                'subtotal' => $subtotal,
                'balance_used' => $balanceUsed,
                'card_paid' => $cardPaid,
                'total' => $subtotal,
                'shipping_address' => $data['shipping_address'],
                'shipping_city' => $data['shipping_city'] ?? $user->city,
                'shipping_phone' => $data['shipping_phone'] ?? $user->phone,
                'card_last_four' => substr($data['card_number'] ?? '0000', -4),
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->subtotal,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }

            if ($balanceUsed > 0) {
                $this->balanceService->debit(
                    $user,
                    $balanceUsed,
                    'order_payment',
                    "Sipariş #{$order->order_number} bakiye kullanımı",
                    $order
                );
            }

            $this->cartService->clear($cart);

            return $order->load('items');
        });
    }

    public function approve(Order $order): void
    {
        $order->update([
            'status' => OrderStatus::Approved->value,
            'approved_at' => now(),
        ]);
    }

    public function advanceStage(Order $order): void
    {
        $current = OrderStatus::from($order->status);
        $next = $current->nextStage();

        if (! $next) {
            throw new \RuntimeException('Sipariş bir sonraki aşamaya geçirilemez.');
        }

        $order->update(['status' => $next->value]);
    }

    public function cancelByUser(Order $order): void
    {
        if (! OrderStatus::from($order->status)->canUserCancel()) {
            throw new \RuntimeException('Bu sipariş iptal edilemez.');
        }

        DB::transaction(function () use ($order) {
            $order->update([
                'status' => OrderStatus::Cancelled->value,
                'cancelled_at' => now(),
            ]);

            $this->balanceService->refundOrder($order);
        });
    }

    public function confirmReceipt(Order $order): void
    {
        if (! OrderStatus::from($order->status)->canUserConfirmReceipt()) {
            throw new \RuntimeException('Teslim onayı yapılamaz.');
        }

        $order->update([
            'status' => OrderStatus::Completed->value,
            'completed_at' => now(),
        ]);
    }
}
