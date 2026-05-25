@extends('layouts.admin')
@section('title', $user->name)
@section('content')
<h2>{{ $user->name }}</h2>
<p>E-posta: {{ $user->email }} | Telefon: {{ $user->phone ?? '-' }}</p>
<p>Bakiye: <strong>{{ number_format($user->balance, 2, ',', '.') }} ₺</strong></p>
<h4>Siparişler</h4>
<ul>
    @forelse($user->orders as $o)
        <li><a href="{{ route('admin.orders.show', $o) }}">{{ $o->order_number }}</a> — {{ $o->status_enum->label() }}</li>
    @empty
        <li>Sipariş yok</li>
    @endforelse
</ul>
<a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">Düzenle</a>
@endsection
