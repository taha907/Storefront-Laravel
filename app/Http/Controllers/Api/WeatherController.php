<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    public function current(WeatherService $weatherService)
    {
        return response()->json($weatherService->getCurrentWeather());
    }
}
