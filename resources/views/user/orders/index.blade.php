@extends('layouts.app')
@section('title', 'Siparişlerim')
@section('content')
<div class="container py-4">
    <h2>Siparişlerim</h2>
    <table class="table table-hover">
        <thead><tr><th>No</th><th>Tarih</th><th>Tutar</th><th>Durum</th><th></th></tr></thead>
        <tbody>
        @forelse($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->created_at->format('d.m.Y') }}</td>
                <td>{{ number_format($order->total, 2, ',', '.') }} ₺</td>
                <td><span class="badge bg-info">{{ $order->status_enum->label() }}</span></td>
                <td><a href="{{ route('user.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Detay</a></td>
            </tr>
        @empty
            <tr><td colspan="5">Sipariş yok.</td></tr>
        @endforelse
        </tbody>
    </table>
    {{ $orders->links() }}
</div>
@endsection
