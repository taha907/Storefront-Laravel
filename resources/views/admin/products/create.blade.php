@extends('layouts.admin')
@section('title', 'Ürün Ekle')
@section('content')
<h2>Yeni Ürün</h2>
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.products._form')
    <button class="btn btn-primary">Kaydet</button>
</form>
@endsection
