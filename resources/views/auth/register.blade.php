@extends('layouts.app')
@section('title', 'Kayıt Ol')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Kayıt Ol</h3>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3"><label>Ad Soyad</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
                        <div class="mb-3"><label>E-posta</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
                        <div class="mb-3"><label>Şifre</label><input type="password" name="password" class="form-control" required></div>
                        <div class="mb-3"><label>Şifre Tekrar</label><input type="password" name="password_confirmation" class="form-control" required></div>
                        <div class="mb-3"><label>Telefon</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
                        <div class="mb-3"><label>Adres</label><textarea name="address" class="form-control">{{ old('address') }}</textarea></div>
                        <div class="mb-3"><label>Şehir</label><input type="text" name="city" class="form-control" value="{{ old('city', 'Kocaeli') }}"></div>
                        <button class="btn btn-primary w-100">Kayıt Ol</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
