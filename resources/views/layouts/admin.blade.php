<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — OneTap Yönetim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .sidebar { min-height: 100vh; background: #0f172a; }
        .sidebar .nav-link { color: #94a3b8; border-radius: .5rem; margin-bottom: .25rem; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(99,102,241,.3); }
    </style>
</head>
<body class="bg-light">
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 sidebar p-3">
            <h5 class="text-white mb-4"><i class="bi bi-lightning-charge-fill text-warning"></i> OneTap</h5>
            <ul class="nav flex-column">
                <li><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid"></i> Özet</a></li>
                <li><a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><i class="bi bi-box"></i> Ürünler</a></li>
                <li><a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}"><i class="bi bi-receipt"></i> Siparişler</a></li>
                <li><a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people"></i> Kullanıcılar</a></li>
                <li><a class="nav-link" href="{{ route('admin.profile') }}"><i class="bi bi-person"></i> Profil</a></li>
                <li><a class="nav-link" href="{{ route('home') }}"><i class="bi bi-shop"></i> Siteye Dön</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">@csrf
                        <button class="nav-link border-0 bg-transparent w-100 text-start"><i class="bi bi-box-arrow-right"></i> Çıkış</button>
                    </form>
                </li>
            </ul>
        </nav>
        <main class="col-md-10 p-4">
            @if(session('success'))<div class="alert alert-success rounded-3">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger rounded-3">{{ session('error') }}</div>@endif
            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
