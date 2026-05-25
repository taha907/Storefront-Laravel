<?php

return [
    'openweather' => [
        'key' => env('OPENWEATHER_API_KEY'),
        'city' => env('STORE_CITY', 'Kocaeli'),
    ],
    'store' => [
        'province' => env('STORE_PROVINCE', 'Kocaeli'),
        'district' => env('STORE_DISTRICT', 'İzmit'),
        'country' => env('STORE_COUNTRY', 'Türkiye'),
    ],
    'google_maps' => [
        'key' => env('GOOGLE_MAPS_API_KEY'),
        'lat' => env('STORE_LAT', 40.7656),
        'lng' => env('STORE_LNG', 29.9408),
    ],
];
