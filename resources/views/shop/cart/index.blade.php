@extends('layouts.app')
@section('title', 'Sepetim')
@section('content')
<div class="container py-4">
    <h2>Sepetim</h2>
    <p class="text-muted">Hesap bakiyeniz: <strong class="text-success">{{ number_format($balance, 2, ',', '.') }} ₺</strong></p>
    @if($cart->items->isEmpty())
        <div class="alert alert-info">Sepetiniz boş. <a href="{{ route('products.index') }}">Alışverişe başlayın</a></div>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Ürün</th><th>Fiyat</th><th>Adet</th><th>Toplam</th><th></th></tr></thead>
                <tbody>
                @foreach($cart->items as $item)
                    <tr>
                        <td>{{ $item->product?->name ?? 'Ürün bulunamadı (kaldırılmış)' }}</td>
                        <td>{{ number_format($item->unit_price, 2, ',', '.') }} ₺</td>
                        <td>
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex gap-1">
                                @csrf @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product?->stock ?? $item->quantity }}" class="form-control form-control-sm" style="width:70px">
                                <button class="btn btn-sm btn-outline-secondary">OK</button>
                            </form>
                        </td>
                        <td>{{ number_format($item->subtotal, 2, ',', '.') }} ₺</td>
                        <td>
                            <form action="{{ route('cart.remove', $item) }}" method="POST">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot><tr><th colspan="3">Toplam</th><th colspan="2">{{ number_format($cart->total, 2, ',', '.') }} ₺</th></tr></tfoot>
            </table>
        </div>
        <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg">Ödemeye Geç</a>
    @endif
</div>
@endsection
