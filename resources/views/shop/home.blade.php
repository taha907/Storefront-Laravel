@extends('layouts.app')
@section('title', 'Ana Sayfa')

@section('content')
<section class="hero py-5">
    <div class="container py-4 text-center">
        <span class="badge bg-warning text-dark mb-3">Kocaeli'nin teknoloji mağazası</span>
        <h1 class="display-4 fw-bold">OneTap Bilgisayar</h1>
        <p class="lead col-lg-7 mx-auto opacity-90">
            İşlemci, ekran kartı, RAM, SSD ve monitör — ihtiyacınız olan parçayı hızlıca bulun.
        </p>
        <div class="mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-light btn-lg px-4 me-2">Alışverişe Başla</a>
            <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg px-4">Mağazamız</a>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="page-header d-flex justify-content-between align-items-end flex-wrap gap-2">
        <div>
            <h2 class="fw-bold mb-1">Kategoriler</h2>
            <p class="text-muted mb-0">İhtiyacınıza göre ürünlere göz atın</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-brand">Tüm Ürünler</a>
    </div>
    <div class="row g-2 mb-5">
        @foreach($categories as $cat)
            <div class="col-6 col-md-auto">
                <a href="{{ route('products.index', ['category' => $cat->id]) }}" class="btn btn-outline-primary rounded-pill px-4">
                    {{ $cat->name }} <span class="badge bg-primary ms-1">{{ $cat->products_count }}</span>
                </a>
            </div>
        @endforeach
    </div>

    <div class="page-header">
        <h2 class="fw-bold mb-1">Öne Çıkan Ürünler</h2>
        <p class="text-muted mb-0">En çok tercih edilen ürünlerimiz</p>
    </div>
    <div class="row g-4">
        @foreach($products as $product)
            @include('shop.partials.product-card', ['product' => $product])
        @endforeach
    </div>
</div>
@endsection
