@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<h2>Dashboard</h2>
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card text-bg-primary"><div class="card-body"><h3>{{ $stats['users'] }}</h3><p class="mb-0">Kullanıcı</p></div></div></div>
    <div class="col-md-3"><div class="card text-bg-success"><div class="card-body"><h3>{{ $stats['products'] }}</h3><p class="mb-0">Ürün</p></div></div></div>
    <div class="col-md-3"><div class="card text-bg-info"><div class="card-body"><h3>{{ $stats['orders'] }}</h3><p class="mb-0">Sipariş</p></div></div></div>
    <div class="col-md-3"><div class="card text-bg-warning"><div class="card-body"><h3>{{ $stats['pending_orders'] }}</h3><p class="mb-0">Onay Bekleyen</p></div></div></div>
</div>
<h4>Son Siparişler</h4>
<table class="table">
    <thead><tr><th>No</th><th>Kullanıcı</th><th>Tutar</th><th>Durum</th><th></th></tr></thead>
    <tbody>
    @foreach($recentOrders as $o)
        <tr>
            <td>{{ $o->order_number }}</td>
            <td>{{ $o->user->name }}</td>
            <td>{{ number_format($o->total, 2, ',', '.') }} ₺</td>
            <td>{{ $o->status_enum->label() }}</td>
            <td><a href="{{ route('admin.orders.show', $o) }}" class="btn btn-sm btn-primary">Görüntüle</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
