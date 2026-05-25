@php
    $stages = [
        'approved' => 'Onaylandı',
        'supplying' => 'Tedarik Ediliyor',
        'boxing' => 'Kutulanıyor',
        'shipped' => 'Kargoya Verildi',
        'on_the_way' => 'Yola Çıktı',
        'delivered' => 'Teslim Edildi',
        'completed' => 'Teslim Alındı',
    ];
    $current = $order->status;
    $stageKeys = array_keys($stages);
    $currentIndex = array_search($current, $stageKeys);
@endphp
<ul class="list-group list-group-flush">
    @foreach($stages as $key => $label)
        @php
            $idx = array_search($key, $stageKeys);
            $done = $currentIndex !== false && $idx !== false && $idx <= $currentIndex;
            $active = $current === $key;
        @endphp
        <li class="list-group-item d-flex align-items-center {{ $active ? 'list-group-item-primary fw-bold' : ($done ? 'text-success' : 'text-muted') }}">
            <i class="bi {{ $done ? 'bi-check-circle-fill' : 'bi-circle' }} me-2"></i>
            {{ $label }}
        </li>
    @endforeach
</ul>
