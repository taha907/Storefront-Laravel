@extends('layouts.app')
@section('title', 'Hakkımızda')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">OneTap Bilgisayar</h1>
        <p class="lead text-muted col-lg-8 mx-auto">
            Kocaeli merkezli online bilgisayar parçaları mağazası. Hızlı teslimat, güvenilir stok ve uygun fiyat.
        </p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h4 class="fw-semibold mb-3">Biz Kimiz?</h4>
                    <p class="text-secondary">
                        OneTap Bilgisayar, oyuncular ve profesyoneller için işlemci, ekran kartı, bellek,
                        depolama ve monitör kategorilerinde seçilmiş ürünler sunar. Amacımız doğru parçayı
                        tek tıkla bulmanızı sağlamak.
                    </p>
                    <p class="text-secondary mb-0">
                        Mağazamız Kocaeli / İzmit bölgesine hizmet vermektedir. Aşağıda mağaza konumumuzu
                        ve bölgenin güncel hava durumunu görebilirsiniz.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h4 class="fw-semibold mb-3">Neden OneTap?</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex gap-2"><i class="bi bi-check-circle-fill text-primary"></i> Geniş ve güncel ürün kataloğu</li>
                        <li class="mb-3 d-flex gap-2"><i class="bi bi-check-circle-fill text-primary"></i> Kolay sipariş ve takip</li>
                        <li class="mb-3 d-flex gap-2"><i class="bi bi-check-circle-fill text-primary"></i> Hesap bakiyesi ile pratik ödeme</li>
                        <li class="mb-3 d-flex gap-2"><i class="bi bi-check-circle-fill text-primary"></i> Güvenli alışveriş deneyimi</li>
                        <li class="d-flex gap-2"><i class="bi bi-check-circle-fill text-primary"></i> Yerel destek — Kocaeli</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @include('shop.partials.weather-map-panel', ['weather' => $weather])
</div>
@endsection
