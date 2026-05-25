<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'status', 'subtotal', 'balance_used',
        'card_paid', 'total', 'shipping_address', 'shipping_city',
        'shipping_phone', 'card_last_four', 'approved_at', 'cancelled_at',
        'completed_at', 'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'balance_used' => 'decimal:2',
            'card_paid' => 'decimal:2',
            'total' => 'decimal:2',
            'approved_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusEnumAttribute(): OrderStatus
    {
        return OrderStatus::from($this->status);
    }
}
