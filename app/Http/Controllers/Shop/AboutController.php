<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Services\WeatherService;

class AboutController extends Controller
{
    public function index(WeatherService $weatherService)
    {
        $weather = $weatherService->getCurrentWeather();

        return view('shop.about', compact('weather'));
    }
}
