<?php

namespace App\DTOs;

class WeatherData
{
    public function __construct(
        public string $city,
        public float $temperature,
        public string $description,
        public string $timestamp,
        public string $source,
    ) {}
}