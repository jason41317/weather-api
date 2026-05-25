<?php

namespace App\Http\Controllers;

use App\Exceptions\WeatherServiceException;
use App\Http\Resources\WeatherResource;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{
    public function __construct(
        protected WeatherService $weatherService
    ) {}

    public function show(string $city): JsonResponse|WeatherResource
    {
        try {

            $weather = $this->weatherService->getWeather($city);

            return (new WeatherResource($weather))
                ->additional([
                    'success' => true,
                    'message' => 'Weather data retrieved successfully.',
                ]);

        } catch (WeatherServiceException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getStatus());
        }
    }

    public function cached(string $city): JsonResponse|WeatherResource
    {
        try {

            $weather = $this->weatherService->getCachedWeather($city);

            return (new WeatherResource($weather))
                ->additional([
                    'success' => true,
                    'message' => 'Weather data retrieved successfully.',
                ]);

        } catch (WeatherServiceException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getStatus());
        }
    }
}