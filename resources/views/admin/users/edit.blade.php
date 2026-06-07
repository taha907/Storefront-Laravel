@extends('layouts.admin')
@section('title', 'Kullanıcı Düzenle')
@section('content')
<h2>Kullanıcı Düzenle</h2>
<form action="{{ route('admin.users.update', $user) }}" method="POST">
    @csrf @method('PUT')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="mb-3"><label>Ad</label><input type="text" name="name" class="form-control" value="{{ $user->name }}" required></div>
    <div class="mb-3"><label>E-posta</label><input type="email" name="email" class="form-control" value="{{ $user->email }}" required></div>
    <div class="mb-3"><label>Telefon</label><input type="text" name="phone" class="form-control" value="{{ $user->phone }}"></div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="active" @checked($user->is_active)>
        <label class="form-check-label" for="active">Hesap Aktif</label>
    </div>
    <button class="btn btn-primary">Kaydet</button>
</form>
@endsection
