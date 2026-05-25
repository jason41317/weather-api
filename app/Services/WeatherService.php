<?php

namespace App\Services;

use App\DTOs\WeatherData;
use App\Exceptions\WeatherServiceException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getWeather(string $city): WeatherData
    {
        try {
            $response = Http::withoutVerifying()
                ->get(
                config('services.openweather.base_url') . '/weather',
                [
                    'q' => $city,
                    'appid' => config('services.openweather.api_key'),
                    'units' => 'metric',
                ]
            );

            if ($response->status() === 404) {
                throw new WeatherServiceException('City not found.', 404);
            }

            if ($response->failed()) {
                throw new WeatherServiceException('Weather service unavailable.', 503);
            }

            $data = $response->json();

            return new WeatherData(
                city: $data['name'],
                temperature: $data['main']['temp'],
                description: $data['weather'][0]['description'],
                timestamp: now()->toISOString(),
                source: 'external',
            );

        } catch (WeatherServiceException $e) {
            throw $e;

        } catch (ConnectionException $e) {
            throw new WeatherServiceException('Weather service timeout.', 504);

        } catch (\Throwable $e) {
            throw new WeatherServiceException(
                'Unexpected error: ' . $e->getMessage(),
                500
            );
        }
    }

    public function getCachedWeather(string $city): WeatherData
    {
        $data = Cache::remember(
            "weather:$city",
            now()->addMinutes(10),
            function () use ($city) {
                $weather = $this->getWeather($city);

                return [
                    'city' => $weather->city,
                    'temperature' => $weather->temperature,
                    'description' => $weather->description,
                    'timestamp' => $weather->timestamp,
                    'source' => $weather->source,
                ];
            }
        );

        return new WeatherData(
            city: $data['city'],
            temperature: $data['temperature'],
            description: $data['description'],
            timestamp: $data['timestamp'],
            source: $data['source'],
        );
    }
}