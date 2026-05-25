@extends('layouts.app')
@section('title', 'Profil Düzenle')
@section('content')
<div class="container py-4 col-md-6">
    <h2>Profil Düzenle</h2>
    <form method="POST" action="{{ route('user.profile.update') }}">
        @csrf @method('PUT')
        <div class="mb-3"><label>Ad Soyad</label><input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required></div>
        <div class="mb-3"><label>E-posta</label><input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required></div>
        <div class="mb-3"><label>Telefon</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}"></div>
        <div class="mb-3"><label>Adres</label><textarea name="address" class="form-control">{{ old('address', $user->address) }}</textarea></div>
        <div class="row">
            <div class="col-md-4 mb-3"><label>Şehir</label><input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}"></div>
            <div class="col-md-4 mb-3"><label>İlçe</label><input type="text" name="district" class="form-control" value="{{ old('district', $user->district) }}"></div>
            <div class="col-md-4 mb-3"><label>Posta Kodu</label><input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $user->postal_code) }}"></div>
        </div>
        <button class="btn btn-primary">Kaydet</button>
        <a href="{{ route('user.profile') }}" class="btn btn-secondary">İptal</a>
    </form>
</div>
@endsection
