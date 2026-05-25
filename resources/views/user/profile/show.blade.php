@extends('layouts.app')
@section('title', 'Hesabım')
@section('content')
<div class="container py-4">
    <h2>Hesabım</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm"><div class="card-body">
                <h5>{{ $user->name }}</h5>
                <p class="mb-1"><i class="bi bi-envelope"></i> {{ $user->email }}</p>
                <p class="mb-1"><i class="bi bi-telephone"></i> {{ $user->phone ?? '-' }}</p>
                <p class="mb-0"><i class="bi bi-geo-alt"></i> {{ $user->address ?? '-' }}, {{ $user->city ?? '' }}</p>
                <hr>
                <p class="fs-4 text-success fw-bold">Bakiye: {{ number_format($balance, 2, ',', '.') }} ₺</p>
                <a href="{{ route('user.profile.edit') }}" class="btn btn-outline-primary btn-sm">Profili Düzenle</a>
                <a href="{{ route('user.profile.password') }}" class="btn btn-outline-secondary btn-sm">Şifre Değiştir</a>
            </div></div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm"><div class="card-body">
                <h5>Bakiye Hareketleri</h5>
                <table class="table table-sm">
                    <thead><tr><th>Tarih</th><th>Açıklama</th><th>Tutar</th></tr></thead>
                    <tbody>
                    @forelse($transactions as $t)
                        <tr>
                            <td>{{ $t->created_at->format('d.m.Y H:i') }}</td>
                            <td>{{ $t->description ?? $t->type }}</td>
                            <td class="{{ $t->amount >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format($t->amount, 2, ',', '.') }} ₺</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-muted">Henüz hareket yok.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div></div>
            <div class="card shadow-sm mt-3 border-warning"><div class="card-body">
                <h6 class="text-warning">Üyeliği Pasif Et</h6>
                <form action="{{ route('user.profile.deactivate') }}" method="POST" onsubmit="return confirm('Üyeliğinizi pasif etmek istediğinize emin misiniz?')">
                    @csrf
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="confirm" value="1" id="confirm" required>
                        <label class="form-check-label" for="confirm">Onaylıyorum</label>
                    </div>
                    <button class="btn btn-warning btn-sm">Üyeliği Pasif Et</button>
                </form>
            </div></div>
        </div>
    </div>
</div>
@endsection
