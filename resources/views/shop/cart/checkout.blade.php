@extends('layouts.app')
@section('title', 'Ödeme')
@section('content')
<div class="container py-4">
    <h2>Ödeme</h2>
    <div class="row g-4">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('checkout.place') }}" method="POST">
                        @csrf
                        <h5>Teslimat Bilgileri</h5>
                        <div class="mb-3">
                            <label class="form-label">Adres</label>
                            <textarea name="shipping_address" class="form-control" required>{{ old('shipping_address', $user->address) }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Şehir</label>
                                <input type="text" name="shipping_city" class="form-control" value="{{ old('shipping_city', $user->city) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telefon</label>
                                <input type="text" name="shipping_phone" class="form-control" value="{{ old('shipping_phone', $user->phone) }}">
                            </div>
                        </div>
                        <h5 class="mt-3">Kredi Kartı (Simülasyon)</h5>
                        <p class="small text-muted">Önce hesap bakiyenizden düşülür, kalan tutar karttan tahsil edilir.</p>
                        <div class="mb-3"><label>Kart Numarası</label><input type="text" name="card_number" class="form-control" placeholder="4111111111111111" required maxlength="19"></div>
                        <div class="mb-3"><label>Kart Üzerindeki İsim</label><input type="text" name="card_name" class="form-control" required></div>
                        <div class="row">
                            <div class="col-6 mb-3"><label>Son Kullanma</label><input type="text" name="card_expiry" class="form-control" placeholder="12/28" required></div>
                            <div class="col-6 mb-3"><label>CVV</label><input type="text" name="card_cvv" class="form-control" required maxlength="4"></div>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg w-100">Siparişi Tamamla</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Sipariş Özeti</h5>
                    @foreach($cart->items as $item)
                        <div class="d-flex justify-content-between small"><span>{{ $item->product->name }} x{{ $item->quantity }}</span><span>{{ number_format($item->subtotal, 2, ',', '.') }} ₺</span></div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between"><span>Toplam</span><strong>{{ number_format($cart->total, 2, ',', '.') }} ₺</strong></div>
                    <div class="d-flex justify-content-between text-success"><span>Bakiyeden</span><span>-{{ number_format(min($balance, $cart->total), 2, ',', '.') }} ₺</span></div>
                    <div class="d-flex justify-content-between"><span>Karttan</span><strong>{{ number_format(max(0, $cart->total - $balance), 2, ',', '.') }} ₺</strong></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
