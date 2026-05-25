@extends('layouts.app')
@section('title', 'Sipariş #'.$order->order_number)
@section('content')
<div class="container py-4">
    <h2>Sipariş #{{ $order->order_number }}</h2>
    <p><strong>Durum:</strong> <span class="badge bg-primary">{{ $order->status_enum->label() }}</span></p>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm"><div class="card-body">
                <h5>Ürünler</h5>
                @foreach($order->items as $item)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>{{ $item->product_name }} x{{ $item->quantity }}</span>
                        <span>{{ number_format($item->total_price, 2, ',', '.') }} ₺</span>
                    </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between"><span>Toplam</span><strong>{{ number_format($order->total, 2, ',', '.') }} ₺</strong></div>
                <small class="text-muted">Bakiye: {{ number_format($order->balance_used, 2, ',', '.') }} ₺ | Kart: {{ number_format($order->card_paid, 2, ',', '.') }} ₺</small>
            </div></div>
            <div class="mt-3">
                @if($order->status_enum->canUserCancel())
                    <form action="{{ route('user.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('İptal edilsin mi? Tutar hesap bakiyenize iade edilir.')">
                        @csrf
                        <button class="btn btn-danger">Siparişi İptal Et</button>
                    </form>
                @endif
                @if($order->status_enum->canUserConfirmReceipt())
                    <form action="{{ route('user.orders.confirm', $order) }}" method="POST">
                        @csrf
                        <button class="btn btn-success btn-lg"><i class="bi bi-check2-circle"></i> Ürünlerimi Teslim Aldım</button>
                    </form>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm"><div class="card-body">
                <h5>Sipariş Takibi</h5>
                @include('partials.order-timeline', ['order' => $order])
            </div></div>
        </div>
    </div>
</div>
@endsection
