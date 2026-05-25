@php $product = $product ?? null; @endphp
<div class="row g-3">
    <div class="col-md-6"><label>Kategori</label>
        <select name="category_id" class="form-select" required>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $product?->category_id) == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6"><label>Marka</label><input type="text" name="brand" class="form-control" value="{{ old('brand', $product?->brand) }}"></div>
    <div class="col-12"><label>Ürün Adı</label><input type="text" name="name" class="form-control" value="{{ old('name', $product?->name) }}" required></div>
    <div class="col-12"><label>Açıklama</label><textarea name="description" class="form-control" rows="4" required>{{ old('description', $product?->description) }}</textarea></div>
    <div class="col-md-4"><label>Fiyat (₺)</label><input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product?->price) }}" required></div>
    <div class="col-md-4"><label>Stok</label><input type="number" name="stock" class="form-control" value="{{ old('stock', $product?->stock ?? 0) }}" required></div>
    <div class="col-md-4"><label class="d-block">Satışa Sun</label>
        <input type="checkbox" name="is_published" value="1" class="form-check-input" @checked(old('is_published', $product?->is_published))>
    </div>
    <div class="col-12"><label>Görseller</label><input type="file" name="images[]" class="form-control" multiple accept="image/*"></div>
</div>
