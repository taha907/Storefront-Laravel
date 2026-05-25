@extends('layouts.app')
@section('title', 'Şifre Değiştir')
@section('content')
<div class="container py-4 col-md-5">
    <h2>Şifre Değiştir</h2>
    <form method="POST" action="{{ route('user.profile.password.update') }}">
        @csrf @method('PUT')
        <div class="mb-3"><label>Mevcut Şifre</label><input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>@error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label>Yeni Şifre</label><input type="password" name="password" class="form-control" required></div>
        <div class="mb-3"><label>Yeni Şifre Tekrar</label><input type="password" name="password_confirmation" class="form-control" required></div>
        <button class="btn btn-primary">Güncelle</button>
    </form>
</div>
@endsection
