@extends('layouts.app')
@section('title', $product->name)
@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Ürünler</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>
    <div class="row g-5">
        <div class="col-lg-5">
            @php $img = $product->primaryImage(); @endphp
            <div class="card border-0 shadow-sm overflow-hidden rounded-4">
                <img src="{{ $img ? asset('storage/'.$img->path) : 'https://picsum.photos/seed/onetap-'.$product->id.'/600/500' }}"
                     class="w-100" style="object-fit:cover;max-height:480px" alt="{{ $product->name }}"
                     onerror="this.src='https://picsum.photos/seed/onetap-{{ $product->id }}/600/500'">
            </div>
        </div>
        <div class="col-lg-7">
            <span class="badge rounded-pill text-bg-light text-primary mb-2">{{ $product->category->name }}</span>
            <h1 class="fw-bold">{{ $product->name }}</h1>
            @if($product->brand)<p class="text-muted fs-5">{{ $product->brand }}</p>@endif
            <p class="display-6 text-primary fw-bold">{{ number_format($product->price, 2, ',', '.') }} ₺</p>
            <p class="mb-4">
                @if($product->inStock())
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">Stokta — {{ $product->stock }} adet</span>
                @else
                    <span class="badge bg-danger-subtle text-danger px-3 py-2">Stokta yok</span>
                @endif
            </p>
            <p class="text-secondary lead">{{ $product->description }}</p>
            <div class="d-flex gap-2 flex-wrap mt-4">
                @auth
                    @if(!auth()->user()->isAdmin() && $product->inStock())
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <button class="btn btn-brand btn-lg px-4"><i class="bi bi-bag-plus"></i> Sepete Ekle</button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-brand btn-lg">Giriş Yap & Satın Al</a>
                @endauth
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-lg">Ürünlere Dön</a>
            </div>
        </div>
    </div>
    @if($related->count())
        <h3 class="fw-bold mt-5 mb-4">Benzer Ürünler</h3>
        <div class="row g-4">
            @foreach($related as $p)
                @include('shop.partials.product-card', ['product' => $p])
            @endforeach
        </div>
    @endif
</div>
@endsection
