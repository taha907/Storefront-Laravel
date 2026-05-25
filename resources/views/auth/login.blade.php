@extends('layouts.app')
@section('title', 'Giriş')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-lightning-charge-fill text-warning fs-1"></i>
                        <h3 class="fw-bold mt-2">Giriş Yap</h3>
                        <p class="text-muted small">OneTap Bilgisayar hesabınıza erişin</p>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">E-posta</label>
                            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Şifre</label>
                            <input type="password" name="password" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-4 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Beni hatırla</label>
                        </div>
                        <button class="btn btn-brand btn-lg w-100">Giriş Yap</button>
                    </form>
                    <p class="text-center mt-4 mb-0 text-muted">Hesabınız yok mu? <a href="{{ route('register') }}">Kayıt olun</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
