@extends('layouts.admin')
@section('title', 'Sipariş Detay')
@section('content')
<h2>Sipariş #{{ $order->order_number }}</h2>
<p><strong>Müşteri:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
<p><strong>Durum:</strong> {{ $order->status_enum->label() }}</p>
<p><strong>Adres:</strong> {{ $order->shipping_address }}, {{ $order->shipping_city }}</p>

<div class="row g-4">
    <div class="col-md-7">
        <table class="table">
            <thead><tr><th>Ürün</th><th>Adet</th><th>Toplam</th></tr></thead>
            <tbody>
            @foreach($order->items as $item)
                <tr><td>{{ $item->product_name }}</td><td>{{ $item->quantity }}</td><td>{{ number_format($item->total_price, 2, ',', '.') }} ₺</td></tr>
            @endforeach
            </tbody>
            <tfoot><tr><th colspan="2">Genel Toplam</th><th>{{ number_format($order->total, 2, ',', '.') }} ₺</th></tr></tfoot>
        </table>

        <div class="d-flex gap-2 flex-wrap">
            @if($order->status === 'pending')
                <form action="{{ route('admin.orders.approve', $order) }}" method="POST">@csrf
                    <button class="btn btn-success">Siparişi Onayla</button>
                </form>
            @endif
            @if($order->status_enum->canAdminAdvance())
                <form action="{{ route('admin.orders.advance', $order) }}" method="POST">@csrf
                    <button class="btn btn-primary"><i class="bi bi-arrow-right"></i> Aşamayı İlerlet</button>
                </form>
            @endif
        </div>

        <form action="{{ route('admin.orders.note', $order) }}" method="POST" class="mt-3">
            @csrf @method('PUT')
            <label>Admin Notu</label>
            <textarea name="admin_note" class="form-control">{{ $order->admin_note }}</textarea>
            <button class="btn btn-sm btn-secondary mt-1">Not Kaydet</button>
        </form>
    </div>
    <div class="col-md-5">
        @include('partials.order-timeline', ['order' => $order])
    </div>
</div>
@endsection
