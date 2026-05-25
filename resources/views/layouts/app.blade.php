<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OneTap Bilgisayar')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #6366f1;
            --brand-dark: #4f46e5;
            --dark: #0f172a;
            --surface: #f1f5f9;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--surface); color: #1e293b; }
        .navbar { background: var(--dark) !important; box-shadow: 0 4px 20px rgba(0,0,0,.15); }
        .navbar-brand { font-weight: 700; font-size: 1.25rem; }
        .nav-link { font-weight: 500; }
        .nav-link:hover { color: #a5b4fc !important; }
        .hero {
            background: linear-gradient(135deg, #0f172a 0%, #312e81 50%, #4f46e5 100%);
            color: #fff;
        }
        .btn-brand { background: var(--brand); border-color: var(--brand); color: #fff; }
        .btn-brand:hover { background: var(--brand-dark); border-color: var(--brand-dark); color: #fff; }
        .product-card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            transition: transform .25s, box-shadow .25s;
            background: #fff;
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px rgba(99,102,241,.15);
        }
        .product-img { height: 220px; object-fit: cover; background: #e2e8f0; }
        .card { border-radius: 1rem; }
        footer { background: var(--dark); color: #94a3b8; }
        .page-header { border-bottom: 1px solid #e2e8f0; padding-bottom: 1rem; margin-bottom: 2rem; }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand text-white" href="{{ route('home') }}">
            <i class="bi bi-lightning-charge-fill text-warning"></i> OneTap Bilgisayar
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Ana Sayfa</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Ürünler</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Hakkımızda</a></li>
            </ul>
            <ul class="navbar-nav align-items-lg-center gap-lg-1">
                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid"></i> Yönetim</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}"><i class="bi bi-bag"></i> Sepet</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('user.orders.index') }}">Siparişlerim</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('user.profile') }}">Hesabım</a></li>
                    @endif
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-link nav-link text-decoration-none">Çıkış</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Giriş</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-brand btn-sm text-white px-3 ms-lg-1" href="{{ route('register') }}">Kayıt Ol</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show m-3 mb-0 rounded-3 shadow-sm" role="alert">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show m-3 mb-0 rounded-3 shadow-sm" role="alert">
        {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@yield('content')

<footer class="py-5 mt-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <strong class="text-white">OneTap Bilgisayar</strong>
                <p class="small mb-0 mt-1">Bilgisayar parçaları ve ekipmanları — Kocaeli</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <a href="{{ route('about') }}" class="text-decoration-none text-secondary small me-3">Hakkımızda</a>
                <a href="{{ route('products.index') }}" class="text-decoration-none text-secondary small">Ürünler</a>
            </div>
        </div>
        <hr class="border-secondary my-4">
        <p class="text-center small mb-0">&copy; {{ date('Y') }} OneTap Bilgisayar. Tüm hakları saklıdır.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
