@extends('layouts.app')
@section('title', 'Ürünler')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Tüm Ürünler</h2>
    <form class="row g-2 mb-4" method="GET">
        <div class="col-md-5"><input type="text" name="q" class="form-control" placeholder="Ara..." value="{{ request('q') }}"></div>
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">Tüm Kategoriler</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3"><button class="btn btn-primary w-100">Filtrele</button></div>
    </form>
    <div class="row g-4">
        @forelse($products as $product)
            @include('shop.partials.product-card', ['product' => $product])
        @empty
            <p class="text-muted">Ürün bulunamadı.</p>
        @endforelse
    </div>
    <div class="mt-4">{{ $products->withQueryString()->links() }}</div>
</div>
@endsection
