@extends('layouts.admin')
@section('title', 'Siparişler')
@section('content')
<h2>Siparişler</h2>
<table class="table table-striped">
    <thead><tr><th>No</th><th>Müşteri</th><th>Tutar</th><th>Durum</th><th>Tarih</th><th></th></tr></thead>
    <tbody>
    @foreach($orders as $o)
        <tr>
            <td>{{ $o->order_number }}</td>
            <td>{{ $o->user->name }}</td>
            <td>{{ number_format($o->total, 2, ',', '.') }} ₺</td>
            <td><span class="badge bg-info">{{ $o->status_enum->label() }}</span></td>
            <td>{{ $o->created_at->format('d.m.Y') }}</td>
            <td><a href="{{ route('admin.orders.show', $o) }}" class="btn btn-sm btn-primary">Detay</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $orders->links() }}
@endsection
