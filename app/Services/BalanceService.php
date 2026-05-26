<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BalanceService
{
    public function getBalance(User $user): float
    {
        if (! Schema::hasTable('user_balances')) {
            return 0.0;
        }

        return (float) $user->balanceTransactions()->sum('amount');
    }

    public function credit(User $user, float $amount, string $type, ?string $description = null, ?Order $order = null): void
    {
        UserBalance::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => $type,
            'description' => $description,
            'order_id' => $order?->id,
        ]);
    }

    public function debit(User $user, float $amount, string $type, ?string $description = null, ?Order $order = null): void
    {
        $this->credit($user, -$amount, $type, $description, $order);
    }

    public function refundOrder(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $refundAmount = $order->total;

            $this->credit(
                $order->user,
                $refundAmount,
                'refund',
                "Sipariş #{$order->order_number} iptal iadesi",
                $order
            );

            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
        });
    }
}
