@extends('layouts.admin')
@section('title', 'Ürünler')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Ürünler</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Yeni Ürün</a>
</div>
<table class="table table-striped">
    <thead><tr><th>Ad</th><th>Kategori</th><th>Fiyat</th><th>Stok</th><th>Durum</th><th>İşlem</th></tr></thead>
    <tbody>
    @foreach($products as $p)
        <tr>
            <td>{{ $p->name }}</td>
            <td>{{ $p->category->name }}</td>
            <td>{{ number_format($p->price, 2, ',', '.') }} ₺</td>
            <td>{{ $p->stock }}</td>
            <td>{!! $p->is_published ? '<span class="badge bg-success">Satışta</span>' : '<span class="badge bg-secondary">Kapalı</span>' !!}</td>
            <td class="text-nowrap">
                <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-primary">Düzenle</a>
                <form action="{{ route('admin.products.publish', $p) }}" method="POST" class="d-inline">@csrf<button class="btn btn-sm btn-outline-warning">Yayın</button></form>
                <form action="{{ route('admin.products.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Silinsin mi?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Sil</button></form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $products->links() }}
@endsection
