<div class="col-md-6 col-lg-3">
    <div class="card product-card h-100">
        @php $img = $product->primaryImage(); @endphp
        <img src="{{ $img ? asset('storage/'.$img->path) : asset('images/no-product.jpg') }}"
             class="card-img-top product-img" alt="{{ $product->name }}"
             onerror="this.src='https://picsum.photos/seed/onetap-{{ $product->id }}/400/300'">
        <div class="card-body d-flex flex-column p-3">
            <span class="badge text-bg-light text-primary align-self-start mb-2">{{ $product->category->name }}</span>
            <h6 class="card-title fw-semibold mb-1">{{ $product->name }}</h6>
            @if($product->brand)
                <small class="text-muted mb-2">{{ $product->brand }}</small>
            @endif
            <p class="text-primary fw-bold fs-5 mb-3 mt-auto">{{ number_format($product->price, 2, ',', '.') }} ₺</p>
            <div class="d-flex gap-2">
                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm flex-grow-1">İncele</a>
                @auth
                    @if(!auth()->user()->isAdmin())
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <button class="btn btn-brand btn-sm" title="Sepete ekle"><i class="bi bi-bag-plus"></i></button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
