<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="mb-0"><i class="bi bi-cloud-sun text-primary"></i> Hava Durumu</h5>
            </div>
            <div class="card-body">
                <div class="rounded-3 bg-light p-3 mb-3 small">
                    <div class="row g-2">
                        <div class="col-6"><span class="text-muted">Ülke</span><br><strong>{{ $weather['country'] ?? 'Türkiye' }}</strong></div>
                        <div class="col-6"><span class="text-muted">İl</span><br><strong>{{ $weather['province'] ?? 'Kocaeli' }}</strong></div>
                        <div class="col-6"><span class="text-muted">İlçe</span><br><strong>{{ $weather['district'] ?? 'İzmit' }}</strong></div>
                        @if(!empty($weather['neighborhood']))
                        <div class="col-6"><span class="text-muted">Semt</span><br><strong>{{ $weather['neighborhood'] }}</strong></div>
                        @endif
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    @if(!($weather['demo'] ?? false))
                        <img src="https://openweathermap.org/img/wn/{{ $weather['icon'] }}@2x.png" alt="" width="72" height="72">
                    @endif
                    <div>
                        <p class="display-6 fw-bold mb-0">{{ $weather['temp'] }}°C</p>
                        <p class="text-muted mb-0 text-capitalize">{{ $weather['description'] }}</p>
                        <small class="text-secondary">Hissedilen {{ $weather['feels_like'] }}°C</small>
                    </div>
                </div>

                <div class="row g-2 mt-3 text-center small">
                    <div class="col-6 col-md-3">
                        <div class="p-2 rounded-3 bg-light">
                            <i class="bi bi-droplet text-primary d-block fs-5"></i>
                            %{{ $weather['humidity'] }}<br><span class="text-muted">Nem</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-2 rounded-3 bg-light">
                            <i class="bi bi-speedometer text-primary d-block fs-5"></i>
                            {{ $weather['pressure'] }}<br><span class="text-muted">Basınç</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-2 rounded-3 bg-light">
                            <i class="bi bi-sunrise text-warning d-block fs-5"></i>
                            {{ $weather['sunrise'] }}<br><span class="text-muted">Doğuş</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-2 rounded-3 bg-light">
                            <i class="bi bi-sunset text-danger d-block fs-5"></i>
                            {{ $weather['sunset'] }}<br><span class="text-muted">Batış</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="mb-0"><i class="bi bi-geo-alt text-primary"></i> Mağazamız</h5>
                <p class="small text-muted mb-0">{{ $weather['district'] ?? 'İzmit' }}, {{ $weather['province'] ?? 'Kocaeli' }}</p>
            </div>
            <div class="card-body p-0 pt-3">
                <div id="store-map" style="height:340px;"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const storeLat = {{ $weather['lat'] }};
    const storeLng = {{ $weather['lng'] }};
    const mapsApiKey = @json(config('services.google_maps.key'));

    function initStoreMap() {
        const center = { lat: storeLat, lng: storeLng };
        const map = new google.maps.Map(document.getElementById('store-map'), {
            zoom: 14,
            center,
            disableDefaultUI: false,
        });
        new google.maps.Marker({
            position: center,
            map,
            title: 'OneTap Bilgisayar — {{ $weather["district"] ?? "İzmit" }}',
        });
    }

    if (mapsApiKey && mapsApiKey !== 'your_google_maps_api_key') {
        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=${mapsApiKey}&callback=initStoreMap`;
        script.async = true;
        document.head.appendChild(script);
    } else {
        document.getElementById('store-map').innerHTML =
            '<div class="d-flex align-items-center justify-content-center h-100 text-muted">Harita yükleniyor...</div>';
    }
</script>
@endpush
