<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    public function getCurrentWeather(): array
    {
        $apiKey = trim((string) config('services.openweather.key'));
        $province = config('services.store.province', 'Kocaeli');
        $district = config('services.store.district', 'İzmit');
        $country = config('services.store.country', 'Türkiye');
        $lat = (float) config('services.google_maps.lat', 40.7656);
        $lng = (float) config('services.google_maps.lng', 29.9408);

        if ($apiKey === '' || $apiKey === 'your_openweather_api_key') {
            return $this->demoData($province, $district, $country, 'OpenWeather API anahtarı .env dosyasında tanımlı değil.');
        }

        try {
            $response = $this->fetchByCity($apiKey, 'Izmit,TR');

            if (! $response->successful()) {
                $response = $this->fetchByCoordinates($apiKey, $lat, $lng);
            }

            if (! $response->successful()) {
                $response = $this->fetchByCity($apiKey, $province.',TR');
            }

            if (! $response->successful()) {
                Log::warning('OpenWeather API hatası', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return $this->demoData($province, $district, $country, 'Hava API yanıt vermedi (HTTP '.$response->status().')');
            }

            $data = $response->json();
            $location = $this->resolveLocation($apiKey, $data, $lat, $lng, $province, $district, $country);

            return array_merge($this->mapWeather($data), $location, [
                'demo' => false,
                'source' => 'OpenWeatherMap API',
            ]);
        } catch (\Throwable $e) {
            Log::error('OpenWeather bağlantı hatası', ['message' => $e->getMessage()]);

            return $this->demoData($province, $district, $country, 'Bağlantı hatası: '.$e->getMessage());
        }
    }

    private function resolveLocation(
        string $apiKey,
        array $weatherData,
        float $lat,
        float $lng,
        string $province,
        string $district,
        string $country,
    ): array {
        $apiLocality = $weatherData['name'] ?? $district;
        $geo = $this->reverseGeocode($apiKey, $lat, $lng);

        $geoName = $geo['name'] ?? null;
        $geoLocalTr = $geo['local_names']['tr'] ?? null;

        // İl: reverse geo veya yapılandırma (Kocaeli)
        $il = $geoLocalTr ?? $geoName ?? $province;
        if ($this->isProvinceLevel($apiLocality) || $this->isProvinceLevel($geoName)) {
            $il = $province;
        }

        // İlçe: mağaza adresi (.env); API farklı semt adı verirse ayrı gösterilir
        $ilce = $district;
        $apiNeighborhood = null;
        if ($apiLocality && ! $this->isProvinceLevel($apiLocality) && mb_strtolower($apiLocality) !== mb_strtolower($district)) {
            $apiNeighborhood = $apiLocality;
        }

        $countryCode = $weatherData['sys']['country'] ?? 'TR';
        $ulke = $countryCode === 'TR' ? 'Türkiye' : $country;

        return [
            'city' => $ilce,
            'province' => $il,
            'district' => $ilce,
            'country' => $ulke,
            'country_code' => $countryCode,
            'locality' => $apiNeighborhood ?? $apiLocality,
            'neighborhood' => $apiNeighborhood,
            'lat' => $weatherData['coord']['lat'] ?? $lat,
            'lng' => $weatherData['coord']['lon'] ?? $lng,
            'coordinates' => sprintf('%.4f, %.4f', $weatherData['coord']['lat'] ?? $lat, $weatherData['coord']['lon'] ?? $lng),
        ];
    }

    private function reverseGeocode(string $apiKey, float $lat, float $lng): array
    {
        try {
            $response = Http::timeout(10)->get('https://api.openweathermap.org/geo/1.0/reverse', [
                'lat' => $lat,
                'lon' => $lng,
                'limit' => 1,
                'appid' => $apiKey,
            ]);

            if ($response->successful() && ! empty($response->json()[0])) {
                return $response->json()[0];
            }
        } catch (\Throwable $e) {
            Log::debug('Reverse geocode atlandı', ['message' => $e->getMessage()]);
        }

        return [];
    }

    private function isProvinceLevel(?string $name): bool
    {
        if (! $name) {
            return false;
        }

        return in_array(mb_strtolower($name), ['kocaeli', 'kocaeli province'], true);
    }

    private function mapWeather(array $data): array
    {
        return [
            'temp' => round($data['main']['temp'] ?? 0, 1),
            'feels_like' => round($data['main']['feels_like'] ?? 0, 1),
            'humidity' => $data['main']['humidity'] ?? 0,
            'pressure' => $data['main']['pressure'] ?? 0,
            'description' => $data['weather'][0]['description'] ?? '',
            'icon' => $data['weather'][0]['icon'] ?? '01d',
            'sunrise' => isset($data['sys']['sunrise']) ? date('H:i', $data['sys']['sunrise']) : null,
            'sunset' => isset($data['sys']['sunset']) ? date('H:i', $data['sys']['sunset']) : null,
        ];
    }

    private function fetchByCoordinates(string $apiKey, float $lat, float $lng)
    {
        return Http::timeout(15)->get('https://api.openweathermap.org/data/2.5/weather', [
            'lat' => $lat,
            'lon' => $lng,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'tr',
        ]);
    }

    private function fetchByCity(string $apiKey, string $query)
    {
        return Http::timeout(15)->get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => $query,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'tr',
        ]);
    }

    private function demoData(string $province, string $district, string $country, ?string $note = null): array
    {
        $lat = config('services.google_maps.lat');
        $lng = config('services.google_maps.lng');

        return [
            'city' => $district,
            'province' => $province,
            'district' => $district,
            'country' => $country,
            'country_code' => 'TR',
            'locality' => $district,
            'temp' => 18.5,
            'feels_like' => 17.2,
            'humidity' => 65,
            'pressure' => 1013,
            'description' => $note ?? 'parçalı bulutlu (demo)',
            'icon' => '02d',
            'sunrise' => '05:42',
            'sunset' => '20:15',
            'lat' => $lat,
            'lng' => $lng,
            'coordinates' => sprintf('%s, %s', $lat, $lng),
            'demo' => true,
            'source' => 'Demo veri',
        ];
    }
}
