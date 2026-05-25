<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Supplying = 'supplying';
    case Boxing = 'boxing';
    case Shipped = 'shipped';
    case OnTheWay = 'on_the_way';
    case Delivered = 'delivered';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Sipariş Alındı (Onay Bekliyor)',
            self::Approved => 'Sipariş Onaylandı',
            self::Supplying => 'Ürünleriniz Tedarik Ediliyor',
            self::Boxing => 'Ürünleriniz Kutulanıyor',
            self::Shipped => 'Ürünleriniz Kargoya Veriliyor',
            self::OnTheWay => 'Ürünleriniz Size Doğru Yola Çıktı',
            self::Delivered => 'Ürünleriniz Size Teslim Edilmiştir',
            self::Completed => 'Teslim Alındı',
            self::Cancelled => 'İptal Edildi',
        };
    }

    public function nextStage(): ?self
    {
        return match ($this) {
            self::Approved => self::Supplying,
            self::Supplying => self::Boxing,
            self::Boxing => self::Shipped,
            self::Shipped => self::OnTheWay,
            self::OnTheWay => self::Delivered,
            default => null,
        };
    }

    public function canUserCancel(): bool
    {
        return $this === self::Pending;
    }

    public function canUserConfirmReceipt(): bool
    {
        return $this === self::Delivered;
    }

    public function canAdminAdvance(): bool
    {
        return in_array($this, [
            self::Approved,
            self::Supplying,
            self::Boxing,
            self::Shipped,
            self::OnTheWay,
        ], true);
    }
}
