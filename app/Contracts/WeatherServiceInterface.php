<?php

namespace App\Contracts;

use App\DTOs\WeatherData;

interface WeatherServiceInterface
{
    public function getWeather(string $city): WeatherData;
    public function getCachedWeather(string $city): WeatherData;
}