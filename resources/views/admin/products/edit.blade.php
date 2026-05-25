@extends('layouts.admin')
@section('title', 'Ürün Düzenle')
@section('content')
<h2>Ürün Düzenle: {{ $product->name }}</h2>
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.products._form', ['product' => $product])
    <button class="btn btn-primary">Güncelle</button>
</form>
@if($product->images->count())
    <h5 class="mt-4">Mevcut Görseller</h5>
    <div class="d-flex gap-2 flex-wrap">
        @foreach($product->images as $img)
            <div class="position-relative">
                <img src="{{ asset('storage/'.$img->path) }}" height="80" class="rounded border" onerror="this.src='https://via.placeholder.com/80'">
                <form action="{{ route('admin.products.image.delete', $img) }}" method="POST" class="mt-1">@csrf @method('DELETE')<button class="btn btn-sm btn-danger w-100">Sil</button></form>
            </div>
        @endforeach
    </div>
@endif
@endsection
