@extends('layouts.admin')
@section('title', 'Admin Profil')
@section('content')
<h2>Admin Profil</h2>
<div class="row g-4">
    <div class="col-md-6">
        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf @method('PUT')
            <div class="mb-3"><label>Ad</label><input type="text" name="name" class="form-control" value="{{ $user->name }}" required></div>
            <div class="mb-3"><label>E-posta</label><input type="email" name="email" class="form-control" value="{{ $user->email }}" required></div>
            <button class="btn btn-primary">Güncelle</button>
        </form>
    </div>
    <div class="col-md-6">
        <form method="POST" action="{{ route('admin.password.update') }}">
            @csrf @method('PUT')
            <div class="mb-3"><label>Yeni Şifre</label><input type="password" name="password" class="form-control" required></div>
            <div class="mb-3"><label>Tekrar</label><input type="password" name="password_confirmation" class="form-control" required></div>
            <button class="btn btn-warning">Şifre Sıfırla</button>
        </form>
    </div>
</div>
@endsection
